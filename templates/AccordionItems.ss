<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <% loop $AccordionItems %>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                       aria-expanded="true" aria-controls="collapseOne">
                        $Title
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    $Content
                </div>
            </div>
        </div>
    <% end_loop %>
</div>
