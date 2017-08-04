<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});

function showMe (item, box) {
  var visible = (box.checked) ? "block" : "none";
  document.getElementById(item).style.display = visible;
}
</script>

<h3>
    Create a new election
</h3>
<form action="new.php" method="post">
    <fieldset>
        <div class="form-group">
            <span data-toggle="tooltip" title="The title for your election.">
                <label for="election_title">Title</label>
                <input autocomplete="off" autofocus class="form-control" id="election_title" name="title" placeholder="Title" type="text"/>
            </span>
        </div>
        <div class="form-group">
            <span data-toggle="tooltip" title="The number of candidates for your election. You will specify the candidates on the next page.">
                <label for="election_num_candidates">Number of candidates</label>
                <input autocomplete="off" class="form-control" id="election_num_candidates" name="num_candidates"  type="number"/>
            </span>
        </div>
        <div class="form-group checkbox">
            <span data-toggle="tooltip" title= "If checked, each voter's choice of candidate will not be visible.">
                <label>
                    <input name="anon" type="checkbox" value="anon"/>
                    Anonymous?
                </label>
            </span>
        </div>
        <div class="form-group checkbox">
            <span data-toggle="tooltip" title= "If checked, you must specify a date and time below at which the election will be closed automatically. If unchecked, you will be required to close the election manually.">
                <label>
                <input name="has_end_date" type="checkbox" value="has_end_date" onclick="showMe('date_time_div', this)"/>
                Fixed end date?
                </label>
            </span>
        </div>
        <div id="date_time_div" style="display:none">
            <div class="form-group">
                <span data-toggle="tooltip" title="The date on which the election should be closed.">
                    <label for="election_end_date">End date</label>
                    <input class="form-control" id="election-end-date" name="end_date" type="date" placeholder="DD/MM/YYYY" />
                </span>
            </div>
            <div class="form-group">
                <span data-toggle="tooltip" title="The time at which the election should be closed, in 24 hour format.">
                    <label for="election_end_time">End time</label>
                    <input class="form-control" id="election-end-time" name="end_time" type="time" placeholder="HH:MM" />
                </span>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-default" type="submit">
                <span aria-hidden="true" class="glyphicon glyphicon-arrow-right"></span>
                Next
            </button>
        </div>
    </fieldset>
</form>

