<h3>
    Create a new election
</h3>
<form action="new.php" method="post">
    <fieldset>
        <div class="form-group">
            <label for="election_title">Title</label>
            <input autocomplete="off" autofocus class="form-control" id="election_title" name="title" placeholder="Title" type="text"/>
            <p class="help-block">The title for your election.</p>
        </div>
        <div class="form-group">
            <label for="election_num_candidates">Number of candidates</label>
            <input autocomplete="off" class="form-control" id="election_num_candidates" name="num_candidates"  type="number"/>
            <p class="help-block">The number of candidates for your election. You will specify the candidates on the next page.</p>
        </div>
        <div class="form-group checkbox">
            <label>
                <input name="anon" type="checkbox" value="anon"/>
                Anonymous?
            </label>
            <p class= "help-block">If checked, each voter's choice of candidate will not be visible.</p>
        </div>
        <div class="form-group checkbox">
            <label>
            <input name="has_end_date" type="checkbox" value="has_end_date"/>
            Fixed end date?
            </label>
            <p class= "help-block">If checked, you must specify a date and time below at which the election will be closed automatically. If unchecked, you will be required to close the election manually.</p>
        </div>
        <div class="form-group">
            <label for="election_end_date">End date</label>
            <input class="form-control" id="election-end-date" name="end_date" type="date" placeholder="DD/MM/YYYY" />
            <p class="help-block">The date on which the election should be closed.</p>
        </div>
        <div class="form-group">
            <label for="election_end_time">End time</label>
            <input class="form-control" id="election-end-time" name="end_time" type="time" placeholder="HH:MM" />
            <p class="help-block">The time at which the election should be closed, in 24 hour format.</p>
        </div>
        <div class="form-group">
            <button class="btn btn-default" type="submit">
                <span aria-hidden="true" class="glyphicon glyphicon-arrow-right"></span>
                Next
            </button>
        </div>
    </fieldset>
</form>

