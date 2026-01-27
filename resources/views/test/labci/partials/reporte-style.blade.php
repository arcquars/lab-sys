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
        margin-bottom: 1.5cm;
        margin-left: 1cm;
        margin-right: 1cm;
        /*margin: 0cm 0cm;*/
    }

    body {
        font-family: 'Times New Roman', 'Sansita Swashed', sans-serif;
    }

    .labci-table{
        width: 100%;
    }

    .labci-table tbody tr td {
        width: 50%;
        vertical-align: top;
    }

    .labci-table-p {
        font-size: 12px;
        margin-top: 0;
        margin-bottom: 2px;
    }

    .labci-table-p-b{
        font-size: 10px;
    }

    .labci-table-p > span{
        color: red;
    }

    .labci-h3 {
        font-size: 18px;
        margin: 4px 0;
        color: #00436b;
    }

    .table-head {
        width: 100%;
    }

    .labci-table-4 {
        width: 100%;
    }

    .labci-table-4 tbody tr td{
        width: 25%;
    }
</style>
