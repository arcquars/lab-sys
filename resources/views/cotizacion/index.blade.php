@extends('layouts.public')

@section('content')
<style>
    body { background: #f8fafc; }
    .cotiz-title { font-weight: 700; margin-bottom: 2px; }
    .cotiz-subtitle { color: #64748b; font-size: 13px; margin-bottom: 16px; }

    /* ---------- Buscador ---------- */
    .cotiz-search-wrap {
        position: sticky; top: 0; z-index: 20; background: #f8fafc;
        padding: 8px 0; margin-bottom: 10px; position: relative;
    }
    .cotiz-search-wrap i.cotiz-search-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #64748b; }
    .cotiz-search-input {
        width: 100%; padding: 12px 38px; border: 1px solid #dbe1e8;
        border-radius: 10px; font-size: 15px; box-shadow: 0 1px 2px rgba(0,0,0,.04);
    }
    .cotiz-search-clear {
        display: none; position: absolute; right: 8px; top: 50%; transform: translateY(-50%);
        border: none; background: none; color: #94a3b8; font-size: 16px; padding: 6px;
    }
    #cotizSearchCount { font-size: 12px; color: #64748b; margin: -4px 0 10px 2px; display: none; }

    /* ---------- Grupos ---------- */
    .cotiz-group-block, .cotiz-subgroup-block {
        border: 1px solid #e2e8f0; border-radius: 10px; margin-bottom: 8px; background: #fff; overflow: hidden;
    }
    .cotiz-subgroup-block { margin: 8px 0 0 12px; }
    .cotiz-group-header, .cotiz-subgroup-header {
        display: flex; align-items: center; gap: 8px; padding: 12px; cursor: pointer;
        min-height: 48px;
    }
    .cotiz-group-header:active, .cotiz-subgroup-header:active { background: #f1f5f9; }
    .cotiz-group-check, .cotiz-test-check { width: 20px; height: 20px; flex: 0 0 auto; }
    .cotiz-group-name, .cotiz-subgroup-name { font-weight: 600; flex: 1 1 auto; font-size: 14px; min-width: 0; }
    .cotiz-indent { opacity: .4; margin-right: 4px; }
    .cotiz-price-badge {
        background: #dbeafe; color: #1d4ed8; border-radius: 20px; padding: 2px 9px; font-size: 11.5px; font-weight: 600; white-space: nowrap;
    }
    .cotiz-count-badge { color: #94a3b8; font-size: 11px; white-space: nowrap; }
    .cotiz-arrow { transition: transform .15s; color: #94a3b8; flex: 0 0 auto; }
    .cotiz-group-block.open > .cotiz-group-header .cotiz-arrow,
    .cotiz-subgroup-block.open > .cotiz-subgroup-header .cotiz-arrow { transform: rotate(180deg); }

    .cotiz-group-body { display: none; padding: 0 10px 10px 10px; }
    .cotiz-group-block.open > .cotiz-group-body,
    .cotiz-subgroup-block.open > .cotiz-group-body { display: block; }
    .cotiz-group-body.cotiz-disabled { opacity: .55; pointer-events: none; }

    /* ---------- Tarjetas de análisis ---------- */
    .cotiz-tests-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 6px; }
    @media (max-width: 575px) {
        .cotiz-tests-grid { grid-template-columns: 1fr; }
    }
    .cotiz-test-card {
        position: relative; display: flex; gap: 10px; align-items: center; border: 1px solid #e2e8f0; border-radius: 8px;
        padding: 9px 10px; margin: 0; cursor: pointer; transition: background .15s, border-color .15s;
        min-height: 44px;
    }
    .cotiz-test-card:active { background: #f1f5f9; }
    .cotiz-test-card.checked { background: #eff6ff; border-color: #93c5fd; }
    .cotiz-test-info { min-width: 0; flex: 1 1 auto; }
    .cotiz-test-name { font-size: 13.5px; font-weight: 500; line-height: 1.25; }
    .cotiz-test-meta { display: flex; gap: 6px; align-items: center; font-size: 11px; color: #94a3b8; margin-top: 1px; }
    .cotiz-test-price { color: #0369a1; font-weight: 700; }
    .cotiz-test-type::before { content: '·'; margin-right: 6px; }
    .cotiz-muted { color: #94a3b8 !important; }

    .cotiz-group-body.cotiz-disabled .cotiz-test-card::after {
        content: 'Incluido en el paquete';
        position: absolute; top: -7px; right: 8px; background: #dcfce7; color: #16a34a;
        font-size: 9.5px; font-weight: 700; padding: 1px 6px; border-radius: 10px;
    }

    #cotizNoResults { display: none; text-align: center; padding: 30px 10px; color: #94a3b8; }
    #cotizNoResults i { font-size: 26px; margin-bottom: 6px; display: block; }

    /* ---------- Carrito escritorio (>=992px) ---------- */
    .cotiz-cart-card { position: sticky; top: 16px; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px; background: #fff; }
    .cotiz-cart-item { display: flex; justify-content: space-between; gap: 8px; font-size: 13px; padding: 6px 0; border-bottom: 1px dashed #e2e8f0; }
    .cotiz-cart-total { display: flex; justify-content: space-between; font-weight: 700; font-size: 16px; margin-top: 10px; }
    #cotizCartEmpty { color: #94a3b8; font-size: 13px; }
    .cotiz-clear-link { border: none; background: none; color: #94a3b8; font-size: 12px; padding: 4px 0; }
    .cotiz-clear-link:hover { color: #ef4444; }

    /* ---------- Barra inferior móvil (<992px) ---------- */
    #cotizMobileCart { display: none; }
    @media (max-width: 991px) {
        #cotizMobileCart {
            display: block; position: fixed; left: 0; right: 0; bottom: 0; z-index: 4000;
            background: #fff; border-top: 2px solid #dbeafe; box-shadow: 0 -4px 20px rgba(37,99,235,.12);
        }
        .cotiz-mobile-bar {
            display: flex; align-items: center; justify-content: space-between; gap: 10px;
            padding: 12px 16px; cursor: pointer;
            background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
        }
        .cotiz-mobile-bar-left { display: flex; align-items: center; gap: 8px; min-width: 0; flex: 1 1 auto; }
        .cotiz-mobile-bar-icon { color: #fff; font-size: 16px; }
        .cotiz-mobile-bar-label { font-size: 11px; color: rgba(255,255,255,.75); line-height: 1; }
        .cotiz-mobile-bar-count { font-size: 14px; font-weight: 700; color: #fff; line-height: 1.3; }
        .cotiz-mobile-bar-total { font-size: 19px; font-weight: 800; color: #fff; white-space: nowrap; }
        .cotiz-mobile-bar-chevron { color: rgba(255,255,255,.75); transition: transform .2s; }
        .cotiz-mobile-bar-chevron.open { transform: rotate(180deg); }

        #cotizMobilePanel { display: none; max-height: 60vh; overflow-y: auto; background: #fff; }
        .cotiz-mobile-item { display: flex; justify-content: space-between; gap: 8px; padding: 9px 16px; border-bottom: 1px solid #f1f5f9; font-size: 13px; }
        #cotizMobileEmpty { text-align: center; padding: 18px; color: #94a3b8; font-size: 13px; }
        .cotiz-mobile-footer { padding: 12px 16px; border-top: 1px solid #e2e8f0; background: #f8fafc; }
        .cotiz-mobile-footer-total { display: flex; justify-content: space-between; font-weight: 700; font-size: 15px; margin-bottom: 10px; }
        .cotiz-mobile-save-btn {
            display: block; width: 100%; padding: 13px; border: none; border-radius: 10px;
            background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%); color: #fff; font-size: 15px; font-weight: 700;
        }
        .cotiz-mobile-save-btn:disabled { opacity: .5; }
        .cotiz-mobile-clear-btn { display: block; width: 100%; padding: 8px; margin-top: 4px; border: none; background: none; color: #94a3b8; font-size: 12px; }

        /* Deja espacio para que la barra fija no tape el último análisis */
        #cotizPageBody { padding-bottom: 76px; }
    }
</style>

<h2 class="cotiz-title">Cotización de análisis</h2>
<p class="cotiz-subtitle">
    Selecciona los análisis o paquetes que te interesan para generar una cotización en PDF.
    Los precios son referenciales y pueden variar al momento de realizar el análisis.
</p>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form id="cotizForm" method="POST" action="{{ route('cotizacion.pdf') }}" target="_blank">
    @csrf
    @honeypot
    <div id="cotizPageBody" class="row">
        <div class="col-lg-8">
            <div class="cotiz-search-wrap">
                <i class="fas fa-search cotiz-search-icon"></i>
                <input type="text" id="cotizSearchInput" class="cotiz-search-input" autocomplete="off"
                       placeholder="Buscar por grupo o por análisis...">
                <button type="button" class="cotiz-search-clear" id="cotizSearchClear"><i class="fas fa-times"></i></button>
            </div>
            <div id="cotizSearchCount"></div>

            <div id="cotizTree">
                @include('cotizacion.partials.tree', ['groups' => $groups])
            </div>

            <div id="cotizNoResults">
                <i class="fas fa-search"></i>
                <p>No se encontraron resultados.</p>
            </div>
        </div>

        <div class="col-lg-4 d-none d-lg-block">
            <div class="cotiz-cart-card">
                <h5>Tu cotización</h5>
                <div id="cotizCartItems"></div>
                <p id="cotizCartEmpty">Aún no seleccionaste ningún análisis o grupo.</p>
                <div class="cotiz-cart-total">
                    <span>Total</span>
                    <span id="cotizCartTotal">--</span>
                </div>

                <button type="submit" id="cotizSubmitBtn" class="btn btn-primary btn-block mt-3" disabled>
                    <i class="fas fa-file-pdf"></i> Generar PDF
                </button>
                <button type="button" class="cotiz-clear-link btn-block text-center" onclick="cotizClearAll();">
                    <i class="fas fa-trash-alt"></i> Limpiar todo
                </button>
            </div>
        </div>
    </div>

    {{-- =====================================================
         BARRA INFERIOR MÓVIL — solo < 992px
         ===================================================== --}}
    <div id="cotizMobileCart">
        <div class="cotiz-mobile-bar" onclick="cotizToggleMobilePanel();">
            <div class="cotiz-mobile-bar-left">
                <i class="fas fa-clipboard-list cotiz-mobile-bar-icon"></i>
                <div>
                    <div class="cotiz-mobile-bar-label">Tu cotización</div>
                    <div class="cotiz-mobile-bar-count" id="cotizMobileCount">0 análisis</div>
                </div>
            </div>
            <div class="cotiz-mobile-bar-total" id="cotizMobileTotal">-- Bs.</div>
            <i class="fas fa-chevron-up cotiz-mobile-bar-chevron" id="cotizMobileChevron"></i>
        </div>
        <div id="cotizMobilePanel">
            <div id="cotizMobileEmpty">
                <i class="fas fa-flask" style="font-size:18px;display:block;margin-bottom:6px;"></i>
                Sin análisis seleccionados
            </div>
            <div id="cotizMobileItems"></div>
            <div class="cotiz-mobile-footer">
                <div class="cotiz-mobile-footer-total">
                    <span>Total</span>
                    <span id="cotizMobileFooterTotal">--</span>
                </div>

                <button type="submit" class="cotiz-mobile-save-btn" id="cotizMobileSubmitBtn" disabled>
                    <i class="fas fa-file-pdf"></i> Generar PDF
                </button>
                <button type="button" class="cotiz-mobile-clear-btn" onclick="cotizClearAll();">
                    <i class="fas fa-trash-alt"></i> Limpiar todo
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('js')
<script>
(function () {

    window.cotizToggleGroup = function (headerEl) {
        $(headerEl).closest('.cotiz-group-block, .cotiz-subgroup-block').toggleClass('open');
    };

    window.cotizToggleGroupChilds = function (input) {
        var $block = $(input).closest('.cotiz-group-block, .cotiz-subgroup-block');
        var $body = $block.children('.cotiz-group-body');
        var $checks = $body.find('input[type=checkbox]');
        if ($(input).is(':checked')) {
            $checks.each(function () {
                $(this).prop('checked', false).prop('disabled', true);
                $(this).closest('.cotiz-test-card').removeClass('checked');
            });
            $body.addClass('cotiz-disabled');
        } else {
            $checks.prop('disabled', false);
            $body.removeClass('cotiz-disabled');
        }
        cotizUpdateCart();
    };

    window.cotizOnTestToggle = function (input) {
        $(input).closest('.cotiz-test-card').toggleClass('checked', $(input).is(':checked'));
        cotizUpdateCart();
    };

    window.cotizClearAll = function () {
        $('.cotiz-group-check:checked').each(function () {
            $(this).prop('checked', false);
            cotizToggleGroupChilds(this);
        });
        $('.cotiz-test-check:checked').each(function () {
            $(this).prop('checked', false);
            $(this).closest('.cotiz-test-card').removeClass('checked');
        });
        cotizUpdateCart();
    };

    window.cotizToggleMobilePanel = function () {
        var $panel = $('#cotizMobilePanel');
        var $chevron = $('#cotizMobileChevron');
        if ($panel.is(':visible')) {
            $panel.slideUp(180);
            $chevron.removeClass('open');
        } else {
            $panel.slideDown(180);
            $chevron.addClass('open');
        }
    };

    window.cotizUpdateCart = function () {
        var total = 0;
        var items = [];
        var groupsCounted = {};

        $('.cotiz-test-check:checked').each(function () {
            var $cb = $(this);
            var price = parseFloat($cb.data('price')) || 0;
            var name = $cb.closest('.cotiz-test-card').find('.cotiz-test-name').text().trim();
            var $block = $cb.closest('.cotiz-group-block, .cotiz-subgroup-block');
            var groupId = $block.data('group-id');
            var allZero = parseInt($block.data('all-zero'), 10) === 1;
            var groupPrice = parseFloat($block.data('group-price')) || 0;

            if (allZero && groupPrice > 0) {
                if (!groupsCounted[groupId]) {
                    groupsCounted[groupId] = true;
                    var groupName = $block.find('.cotiz-group-name, .cotiz-subgroup-name').first().text().trim();
                    total += groupPrice;
                    items.push({ name: groupName + ' (paquete)', price: groupPrice });
                }
                items.push({ name: name, price: 0, info: true });
            } else {
                total += price;
                items.push({ name: name, price: price });
            }
        });

        $('.cotiz-group-check:checked').each(function () {
            var $cb = $(this);
            var price = parseFloat($cb.data('price')) || 0;
            var name = $cb.closest('.cotiz-group-header, .cotiz-subgroup-header')
                .find('.cotiz-group-name, .cotiz-subgroup-name').first().text().trim();
            total += price;
            items.push({ name: name + ' (grupo)', price: price });
        });

        var totalFmt = total > 0 ? total.toFixed(2) + ' Bs.' : '--';

        /* ---- Carrito escritorio ---- */
        var $list = $('#cotizCartItems').empty();
        if (items.length === 0) {
            $('#cotizCartEmpty').show();
        } else {
            $('#cotizCartEmpty').hide();
            items.forEach(function (it) {
                var priceHtml = it.info
                    ? '<span class="cotiz-muted">incl.</span>'
                    : (it.price > 0 ? it.price.toFixed(2) + ' Bs.' : '<span class="cotiz-muted">A consultar</span>');
                $list.append('<div class="cotiz-cart-item"><span>' + it.name + '</span><span>' + priceHtml + '</span></div>');
            });
        }
        $('#cotizCartTotal').text(totalFmt);
        $('#cotizSubmitBtn').prop('disabled', items.length === 0);

        /* ---- Barra móvil ---- */
        var $mobileList = $('#cotizMobileItems').empty();
        if (items.length === 0) {
            $('#cotizMobileEmpty').show();
        } else {
            $('#cotizMobileEmpty').hide();
            items.forEach(function (it) {
                var priceHtml = it.info
                    ? '<span class="cotiz-muted">incl.</span>'
                    : (it.price > 0 ? it.price.toFixed(2) + ' Bs.' : '<span class="cotiz-muted">A consultar</span>');
                $mobileList.append('<div class="cotiz-mobile-item"><span>' + it.name + '</span><span>' + priceHtml + '</span></div>');
            });
        }
        $('#cotizMobileCount').text(items.length + ' análisis');
        $('#cotizMobileTotal').text(totalFmt);
        $('#cotizMobileFooterTotal').text(totalFmt);
        $('#cotizMobileSubmitBtn').prop('disabled', items.length === 0);
    };

    $('#cotizSearchClear').on('click', function () {
        $('#cotizSearchInput').val('').trigger('input').focus();
    });

    var searchTimer;
    $('#cotizSearchInput').on('input', function () {
        clearTimeout(searchTimer);
        var val = $(this).val();
        $('#cotizSearchClear').toggle(val.length > 0);
        searchTimer = setTimeout(function () { cotizFilter(val); }, 150);
    });

    window.cotizFilter = function (query) {
        var q = (query || '').toLowerCase().trim();

        if (!q) {
            $('.cotiz-group-block, .cotiz-subgroup-block, .cotiz-test-card').show();
            $('#cotizNoResults').hide();
            $('#cotizSearchCount').hide();
            /* Colapsar los grupos que no tengan nada seleccionado, para no dejar la pantalla saturada */
            $('.cotiz-group-block, .cotiz-subgroup-block').each(function () {
                var $b = $(this);
                if ($b.find('input:checked').length === 0) $b.removeClass('open');
            });
            return;
        }

        var totalVisible = 0;

        $('#cotizTree > .cotiz-group-block').each(function () {
            var $root = $(this);
            var rootMatches = ($root.data('group-name') + '').indexOf(q) !== -1;
            var visibleInRoot = 0;

            $root.children('.cotiz-group-body').children('.cotiz-tests-grid').children('.cotiz-test-card').each(function () {
                var $card = $(this);
                var match = rootMatches || ($card.data('test-name') + '').indexOf(q) !== -1;
                $card.toggle(match);
                if (match) visibleInRoot++;
            });

            $root.find('.cotiz-subgroup-block').each(function () {
                var $sub = $(this);
                var subMatches = rootMatches || ($sub.data('group-name') + '').indexOf(q) !== -1;
                var visibleInSub = 0;

                $sub.children('.cotiz-group-body').children('.cotiz-tests-grid').children('.cotiz-test-card').each(function () {
                    var $card = $(this);
                    var match = subMatches || ($card.data('test-name') + '').indexOf(q) !== -1;
                    $card.toggle(match);
                    if (match) visibleInSub++;
                });

                var subVisible = visibleInSub > 0 || subMatches;
                $sub.toggle(subVisible);
                if (subVisible) { $sub.addClass('open'); visibleInRoot += visibleInSub; }
            });

            var rootVisible = visibleInRoot > 0 || rootMatches;
            $root.toggle(rootVisible);
            if (rootVisible) { $root.addClass('open'); totalVisible += visibleInRoot; }
        });

        $('#cotizNoResults').toggle(totalVisible === 0);
        $('#cotizSearchCount').show().text(totalVisible + (totalVisible === 1 ? ' resultado' : ' resultados'));
    };

    $(function () {
        $('.cotiz-test-check:checked').each(function () {
            $(this).closest('.cotiz-test-card').addClass('checked');
        });
        $('.cotiz-group-check:checked').each(function () {
            cotizToggleGroupChilds(this);
            $(this).closest('.cotiz-group-block, .cotiz-subgroup-block').addClass('open');
        });
        cotizUpdateCart();
    });

})();
</script>
@endpush
