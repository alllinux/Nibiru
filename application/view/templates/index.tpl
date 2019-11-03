{include 'shared/header.tpl'}
<body>
<div class="container">
    <div class="with-iconav">
        {include file="navigation.tpl"}
    </div>
    <div class="col-sm-12 content">
        <div class="dashhead">
            <div class="dashhead-titles">
                <h6 class="dashhead-subtitle">Rapid Prototyping Framework</h6>
                <h2 class="dashhead-title">Nibiru</h2>
            </div>
            <div class="btn-toolbar dashhead-toolbar">
                <div class="btn-toolbar-item input-with-icon">
                    <input type="text" value="01/01/15 - 01/08/15" class="form-control" data-provide="datepicker">
                    <span class="icon icon-calendar"></span>
                </div>
            </div>
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

{include 'shared/footer.tpl'}

</body>
</html>

