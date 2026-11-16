// Run against the real Blade form fixtures exported by IndustrialSampleViewTest.
// See the change's acceptance procedure for the temporary dependency setup.
const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const { JSDOM } = require('jsdom');

const directory = process.env.INDUSTRIAL_SAMPLE_ARTIFACT_DIR;
assert.ok(directory, 'Set INDUSTRIAL_SAMPLE_ARTIFACT_DIR to the exported Blade fixtures');

for (const view of ['analisis.crear-hemo', 'analisis.crear-hemo-v2']) {
    const html = fs.readFileSync(path.join(directory, view + '.html'), 'utf8');
    const dom = new JSDOM(html, { runScripts: 'outside-only', url: 'http://localhost/' });
    const window = dom.window;
    const $ = require('jquery')(window);
    window.$ = window.jQuery = $;
    const industrialScript = [...window.document.scripts].find(script => script.textContent.includes('submit.industrial'));
    assert.ok(industrialScript, 'The shared industrial script must be part of the fixture');
    window.eval(industrialScript.textContent);

    const form = window.document.querySelector('#formAnalisis');
    // Capture native submission without navigating or opening an HTTP connection.
    let submissions = 0;
    form.submit = () => { submissions++; };
    let validationMessages = 0;
    form.reportValidity = () => { validationMessages++; return form.checkValidity(); };
    $.ajax = () => { throw new Error('Toggling industrial mode must not send AJAX'); };

    // Exercise the actual v2 cart's submit handler and buttons, including mobile.
    if (view.endsWith('v2')) {
        const cart = [...window.document.scripts].find(script => script.textContent.includes('window.labCartRefresh ='));
        assert.ok(cart, 'The actual cart script must be part of the fixture');
        window.eval(cart.textContent);
    } else {
        const scripts = [...window.document.scripts].find(script => script.textContent.includes('$("#formAnalisis").submit'));
        // Bind the existing classic form submit handler, leaving unrelated AJAX initialization out.
        const handler = scripts.textContent.match(/\$\("#formAnalisis"\)\.submit\(function \(e\) \{[\s\S]*?\}\);/);
        assert.ok(handler);
        window.eval(handler[0]);
    }

    const checkbox = $('#is_industrial');
    const age = $('input[name="edad"]');
    const product = $('input[name="product_name"]');
    const rehearsal = $('input[name="rehearsal_date"]');
    assert.equal(checkbox.prop('checked'), false);
    assert.equal(age.prop('disabled'), false);
    assert.equal(product.prop('disabled'), true);

    checkbox.prop('checked', true).trigger('change');
    assert.equal(age.prop('disabled'), true);
    assert.equal(product.prop('disabled'), false);
    assert.equal(product.prop('required'), true);
    assert.equal(rehearsal.prop('required'), true);
    assert.equal($('[data-clinical-demographic].d-none').length, 2);
    assert.equal($('[data-client-label]').text(), 'Cliente:');

    const saveButtons = view.endsWith('v2') ? ['#labCartSaveBtn', '#mobileCartSaveBtn'] : ['#btnSubmit'];
    for (const button of saveButtons) {
        $(button).prop('disabled', false);
        product.val('');
        rehearsal.val('');
        $('#formAnalisis').trigger('submit');
        assert.equal(submissions, 0);
        assert.equal($(button).prop('disabled'), false, 'Invalid form must remain editable: ' + button);
        assert.equal($('#btnSubmit').prop('disabled'), false);
    }
    assert.equal(validationMessages, saveButtons.length);

    product.val('Agua industrial');
    rehearsal.val('2026-11-10');
    $('input[name="lot_number"]').val('001-A');
    checkbox.prop('checked', false).trigger('change');
    assert.equal(age.prop('disabled'), false);
    assert.equal(product.prop('disabled'), true);
    assert.equal(product.prop('required'), false);
    assert.equal($('[data-clinical-demographic].d-none').length, 0);
    assert.equal($('[data-client-label]').text(), 'Nombres y Apellidos:');
    assert.equal($('#formAnalisis').serializeArray().some(field => field.name === 'product_name'), false);

    checkbox.prop('checked', true).trigger('change');
    assert.equal(product.val(), 'Agua industrial');
    assert.equal($('input[name="lot_number"]').val(), '001-A');
    assert.equal($('#formAnalisis').serializeArray().some(field => field.name === 'edad'), false);
    assert.ok(form.checkValidity());
    $('#formAnalisis').trigger('submit');
    assert.equal(submissions, 1);
    assert.equal($('#btnSubmit').prop('disabled'), true);
    if (view.endsWith('v2')) {
        assert.equal($('#labCartSaveBtn').prop('disabled'), true);
        assert.equal($('#mobileCartSaveBtn').prop('disabled'), true);
    }
    dom.window.close();
    console.log('PASS ' + view + ': toggle, serialization, required fields and submit handlers');
}
