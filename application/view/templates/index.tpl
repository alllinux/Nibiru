<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">

    <title>
        {$title}
    </title>
    {foreach item=style from=$css}
        <link href="{$style}" rel="stylesheet">
    {/foreach}
    <style>
        /* note: this is a hack for ios iframe for bootstrap themes shopify page */
        /* this chunk of css is not part of the toolkit :) */
        body {
            width: 1px;
            min-width: 100%;
            *width: 100%;
        }
    </style>
</head>


<body>
<div class="container">
    <div class="with-iconav">
        {include file="navigation.tpl"}
    </div>
    <div class="col-sm-12 content">
        <div class="dashhead">
            <div class="dashhead-titles">
                <h6 class="dashhead-subtitle">Dashboards</h6>
                <h2 class="dashhead-title">Order history</h2>
            </div>

            <div class="btn-toolbar dashhead-toolbar">
                <div class="btn-toolbar-item input-with-icon">
                    <input type="text" value="01/01/15 - 01/08/15" class="form-control" data-provide="datepicker">
                    <span class="icon icon-calendar"></span>
                </div>
            </div>
        </div>

        <div class="flextable table-actions">
            <div class="flextable-item flextable-primary">
                <div class="btn-toolbar-item input-with-icon">
                    <input type="text" class="form-control input-block" placeholder="Search orders">
                    <span class="icon icon-magnifying-glass"></span>
                </div>
            </div>
            <div class="flextable-item">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary-outline">
                        <span class="icon icon-pencil"></span>
                    </button>
                    <button type="button" class="btn btn-primary-outline">
                        <span class="icon icon-erase"></span>
                    </button>
                </div>
            </div>
        </div>

        <div class="table-full">
            <div class="table-responsive">
                <table class="table" data-sort="table">
                    <thead>
                    <tr>
                        <th><input type="checkbox" class="select-all" id="selectAll"></th>
                        <th>Order</th>
                        <th>Customer name</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><input type="checkbox" class="select-row"></td>
                        <td><a href="#">#10001</a></td>
                        <td>First Last</td>
                        <td>Admin theme, marketing theme</td>
                        <td>01/01/2015</td>
                        <td>$200.00</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="select-row"></td>
                        <td><a href="#">#10002</a></td>
                        <td>Firstname Lastname</td>
                        <td>Admin theme</td>
                        <td>01/01/2015</td>
                        <td>$100.00</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="select-row"></td>
                        <td><a href="#">#10003</a></td>
                        <td>Name Another</td>
                        <td>Personal blog theme</td>
                        <td>01/01/2015</td>
                        <td>$100.00</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="select-row"></td>
                        <td><a href="#">#10004</a></td>
                        <td>One More</td>
                        <td>Marketing theme, personal blog theme, admin theme</td>
                        <td>01/01/2015</td>
                        <td>$300.00</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="select-row"></td>
                        <td><a href="#">#10005</a></td>
                        <td>Name Right Here</td>
                        <td>Personal blog theme, admin theme</td>
                        <td>01/02/2015</td>
                        <td>$200.00</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="select-row"></td>
                        <td><a href="#">#10006</a></td>
                        <td>First Last</td>
                        <td>Admin theme, marketing theme</td>
                        <td>01/01/2015</td>
                        <td>$200.00</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="select-row"></td>
                        <td><a href="#">#10007</a></td>
                        <td>Firstname Lastname</td>
                        <td>Admin theme</td>
                        <td>01/01/2015</td>
                        <td>$100.00</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="select-row"></td>
                        <td><a href="#">#10008</a></td>
                        <td>Name Another</td>
                        <td>Personal blog theme</td>
                        <td>01/01/2015</td>
                        <td>$100.00</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="select-row"></td>
                        <td><a href="#">#10009</a></td>
                        <td>One More</td>
                        <td>Marketing theme, personal blog theme, admin theme</td>
                        <td>01/01/2015</td>
                        <td>$300.00</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="select-row"></td>
                        <td><a href="#">#10010</a></td>
                        <td>Name Right Here</td>
                        <td>Personal blog theme, admin theme</td>
                        <td>01/02/2015</td>
                        <td>$200.00</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="select-row"></td>
                        <td><a href="#">#10011</a></td>
                        <td>First Last</td>
                        <td>Admin theme, marketing theme</td>
                        <td>01/01/2015</td>
                        <td>$200.00</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="select-row"></td>
                        <td><a href="#">#10012</a></td>
                        <td>Firstname Lastname</td>
                        <td>Admin theme</td>
                        <td>01/01/2015</td>
                        <td>$100.00</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="select-row"></td>
                        <td><a href="#">#10013</a></td>
                        <td>Name Another</td>
                        <td>Personal blog theme</td>
                        <td>01/01/2015</td>
                        <td>$100.00</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="select-row"></td>
                        <td><a href="#">#10014</a></td>
                        <td>One More</td>
                        <td>Marketing theme, personal blog theme, admin theme</td>
                        <td>01/01/2015</td>
                        <td>$300.00</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="select-row"></td>
                        <td><a href="#">#10015</a></td>
                        <td>Name Right Here</td>
                        <td>Personal blog theme, admin theme</td>
                        <td>01/02/2015</td>
                        <td>$200.00</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="select-row"></td>
                        <td><a href="#">#10016</a></td>
                        <td>First Last</td>
                        <td>Admin theme, marketing theme</td>
                        <td>01/01/2015</td>
                        <td>$200.00</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="select-row"></td>
                        <td><a href="#">#10017</a></td>
                        <td>Firstname Lastname</td>
                        <td>Admin theme</td>
                        <td>01/01/2015</td>
                        <td>$100.00</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="select-row"></td>
                        <td><a href="#">#10018</a></td>
                        <td>Name Another</td>
                        <td>Personal blog theme</td>
                        <td>01/01/2015</td>
                        <td>$100.00</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="select-row"></td>
                        <td><a href="#">#10019</a></td>
                        <td>One More</td>
                        <td>Marketing theme, personal blog theme, admin theme</td>
                        <td>01/01/2015</td>
                        <td>$300.00</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="select-row"></td>
                        <td><a href="#">#10020</a></td>
                        <td>Name Right Here</td>
                        <td>Personal blog theme, admin theme</td>
                        <td>01/02/2015</td>
                        <td>$200.00</td>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="text-center">
            <ul class="pagination">
                <li>
                    <a href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li class="active"><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li>
                    <a href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div id="docsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Example modal</h4>
            </div>
            <div class="modal-body">
                <p>You're looking at an example modal in the dashboard theme.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cool, got it!</button>
            </div>
        </div>
    </div>
</div>
{foreach item=script from=$js}
    <script src="{$script}"></script>
{/foreach}
<script>
    // execute/clear BS loaders for docs
    $(function(){
        while( window.BS&&window.BS.loader&&window.BS.loader.length )
        {
            (window.BS.loader.pop())()
        }
    })
</script>
{include file="debugbar.tpl"}
</body>
</html>

