<div class="panel-group" id="accordion-{$AccordionId}" role="tablist" aria-multiselectable="true">
    <% loop $AccordionItems %>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading-{$Up.AccordionId}-{$Pos}">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse"
                       data-parent="#accordion-{$Up.AccordionId}" href="#collapse-{$Up.AccordionId}-{$Pos}"
                       aria-expanded="true" aria-controls="collapse-{$Up.AccordionId}-{$Pos}">
                        $Title
                    </a>
                </h4>
            </div>
            <div id="collapse-{$Up.AccordionId}-{$Pos}" class="panel-collapse collapse in"
                 role="tabpanel" aria-labelledby="heading-{$Up.AccordionId}-{$Pos}">
                <div class="panel-body">
                    $Content
                </div>
            </div>
        </div>
    <% end_loop %>
</div>
