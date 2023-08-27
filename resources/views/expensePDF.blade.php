<!DOCTYPE html>
<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Expense</title>
        <style>
            @font-face {
                font-family: 'Inter';
                src: url('Inter-Regular.ttf') format('truetype');
                font-weight: 400;
                font-style: normal;
            }

            @font-face {
                font-family: 'Inter';
                src: url('Inter-Medium.ttf') format('truetype');
                font-weight: 500;
                font-style: normal;
            }

            @font-face {
                font-family: 'Inter';
                src: url('Inter-Bold.ttf') format('truetype');
                font-weight: 700;
                font-style: normal;
            }

            @font-face {
                font-family: 'Space Mono';
                src: url('SpaceMono-Regular.ttf') format('truetype');
                font-weight: 400;
                font-style: normal;
            }

            body {
                font-size: 0.75rem;
                font-family: 'Inter', sans-serif;
                font-weight: 400;
                color: #000000;
                margin: 0 auto;
                position: relative;
            }

            #pspdfkit-header {
                font-size: 0.625rem;
                text-transform: uppercase;
                letter-spacing: 2px;
                font-weight: 400;
                color: #717885;
                margin-top: 2.5rem;
                margin-bottom: 2.5rem;
                width: 100%;
            }

            .header-columns {
                display: flex;
                justify-content: space-between;
                padding-left: 2.5rem;
                padding-right: 2.5rem;
            }

            .logo {
                height: 1.5rem;
                width: auto;
                margin-right: 1rem;
            }

            .logotype {
                display: flex;
                align-items: center;
                font-weight: 700;
            }

            h2 {
                font-family: 'Space Mono', monospace;
                font-size: 1.25rem;
                font-weight: 400;
            }

            h4 {
                font-family: 'Space Mono', monospace;
                font-size: 1rem;
                font-weight: 400;
            }

            .page {
                margin-left: 5rem;
                margin-right: 5rem;
            }

            .intro-table {
                display: flex;
                justify-content: space-between;
                margin: 3rem 0 5rem 0;
                border-top: 1px solid #000000;
                border-bottom: 1px solid #000000;
            }

            .intro-form {
                display: flex;
                flex-direction: column;
                border-right: 1px solid #000000;
                width: 33%;
            }

            .intro-form:last-child {
                border-right: none;
            }

            .intro-table-title {
                font-size: 0.625rem;
                margin: 0;
            }

            .intro-form-item {
                padding: 1.25rem 1.5rem 1.25rem 1.5rem;
            }

            .intro-form-item:first-child {
                padding-left: 0;
            }

            .intro-form-item:last-child {
                padding-right: 0;
            }

            .intro-form-item-border {
                padding: 1.25rem 0 .75rem 1.5rem;
                border-bottom: 1px solid #000000;
            }

            .intro-form-item-border:last-child {
                border-bottom: none;
            }

            .form {
                display: flex;
                flex-direction: column;
                margin-top: 6rem;
            }

            .no-border {
                border: none;
            }

            .border {
                border: 1px solid #000000;
            }

            .border-bottom {
                border: 1px solid #000000;
                border-top: none;
                border-left: none;
                border-right: none;
            }

            .signer {
                display: flex;
                justify-content: space-between;
                gap: 2.5rem;
                margin: 2rem 0 2rem 0;
            }

            .signer-item {
                flex-grow: 1;
            }

            input {
                color: #4537DE;
                font-family: 'Space Mono', monospace;
                text-align: center;
                margin-top: 1.5rem;
                height: 4rem;
                width: 100%;
                box-sizing: border-box;
            }

            input#date, input#notes {
                text-align: left;
            }

            input#signature {
                height: 8rem;
            }

            .intro-text {
                width: 60%;
            }

            .table-box table, .summary-box table {
                width: 100%;
                font-size: 0.625rem;
            }

            .table-box table {
                padding-top: 2rem;
            }


            .table-box td:last-child, .summary-box td:last-child {
                text-align: right;
            }

            .table-box table tr.heading td {
                border-top: 1px solid #000000;
                border-bottom: 1px solid #000000;
                height: 1.5rem;
            }

            .table-box table tr.item td, .summary-box table tr.item td {
                border-bottom: 1px solid #D7DCE4;
                height: 1.5rem;
            }

            .summary-box table tr.no-border-item td {
                border-bottom: none;
                height: 1.5rem;
            }

            .summary-box table tr.total td {
                border-top: 1px solid #000000;
                border-bottom: 1px solid #000000;
                height: 1.5rem;
            }

            .summary-box table tr.item td:first-child, .summary-box table tr.total td:first-child {
                border: none;
                height: 1.5rem;
            }

            #pspdfkit-footer {
                font-size: 0.5rem;
                text-transform: uppercase;
                letter-spacing: 1px;
                font-weight: 500;
                color: #717885;
                margin-top: 2.5rem;
                bottom: 2.5rem;
                position: absolute;
                width: 100%;
            }

            .footer-columns {
                display: flex;
                justify-content: space-between;
                padding-left: 2.5rem;
                padding-right: 2.5rem;
            }
        </style>
    </head>

    <body>
        <div id="pspdfkit-header">
            <div class="header-columns">
                <div class="logotype">
                    <h3>Expense Caculator</h3>
                </div>
                <div>
                <h4>{{$data['user_name']}}</h4>
                <h4>Total Expense: {{$data['totalExpense']}} AED</h4>
            </div>
            </div>
        </div>



        <div class="page">
            

                <h4>
                    Expense Summary
                </h4>
            
            <div class="table-box">
                <table cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr class="heading">
                            <td>#</td>
                            <td>Title</td>
                            <td>Category</td>
                            <td>Date</td>
                            <td>Description</td>
                            <td>Cost</td>
                        </tr>

                        

                        @foreach($data['expenseList'] as $key => $expense)
                        
                            <tr class="item">
                                <td>{{$key + 1}}</td>
                                <td>{{$expense->title}}</td>
                                <td>{{$expense->category}}</td>
                                <td>{{$expense->date}}</td>
                                <td>{{$expense->description}}</td>
                                <td>{{$expense->cost}}</td>
                            </tr>
                        @endforeach

                        

                    </tbody>
                </table>
            </div>

        </div>

    </body>
</html>