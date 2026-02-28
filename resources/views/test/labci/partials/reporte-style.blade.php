<style>
    @page {
        header: page-header;
        footer: page-footer;

        margin-header: 4mm;
        @if(!isset($sin))
        margin-top: 2.2cm;
        @else
        margin-top: 2.5cm;
        @endif
        margin-bottom: 1.8cm;
        margin-left: 1cm;
        margin-right: 1cm;
        /*margin: 0cm 0cm;*/
    }

    body {
        /* font-family: 'Times New Roman', 'Sansita Swashed', sans-serif; */
        font-family: '{{ config("clinica.report_pdf_font") }}', sans-serif;
    }

    .labci-table{
        width: 100%;
    }

    .labci-table tbody tr td {
        width: 50%;
        vertical-align: top;
    }

    .labci-table-p {
        font-size: 10px;
        margin-top: 0;
        /* margin-bottom: 2px; */
        padding: 0;
    }

    .labci-table-p-b{
        font-size: 9px;
        padding: 0;
        color: #172554;
    }

    .labci-table-p > span{
        color: red;
    }

    .labci-h3 {
        font-family: '{{ config("clinica.report_pdf_font") }}';
        font-size: 16px;
        margin: 4px 0;
        color: #1e3a8a;
    }

    .labci-h4 {
        font-family: '{{ config("clinica.report_pdf_font") }}';
        font-size: 12px;
        margin: 4px 0;
        color: #1e3a8a;
    }

    .table-head {
        width: 100%;
    }

    .labci-table-4 {
        width: 100%;
    }

     .labci-table-4 tbody tr td{
        margin: 0;
        padding: 0;
    }
</style>
