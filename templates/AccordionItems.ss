<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <% loop $AccordionItems %>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading{$Pos}">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{$Pos}"
                       aria-expanded="true" aria-controls="collapse{$Pos}">
                        $Title
                    </a>
                </h4>
            </div>
            <div id="collapse{$Pos}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading{$Pos}">
                <div class="panel-body">
                    $Content
                </div>
            </div>
        </div>
    <% end_loop %>
</div>
