<h3>
    Vote in <?=htmlspecialchars($election_title) ?>
</h3>
    <div>
    <form action="vote.php" method="post">
        <fieldset>
            <div class="form-group">
                <label for="voter_name">Name</label>
                <input autocomplete="off" autofocus class="form-control" id="voter_name" name="voter_name" placeholder="Name" type="text"/>
                <p class="help-block">Please enter your name.</p>
            </div>
            <div class="form-group">
                <label>Select a candidate:</label>
                <?php for($i = 0; $i < $num_candidates; $i++): ?>
                    <div>
                        <input type="radio" name="candidate" value=<?=$i ?> >
                        <?= htmlspecialchars($candidate_names[$i]) ?>
                        <br>
                    </div>
                <?php endfor; ?>
            </div>
            <div class="form-group">
                <button class="btn btn-default" type="submit">
                    <span aria-hidden="true" class="glyphicon glyphicon-ok"></span>
                    Vote
                </button>
            </div>
        </fieldset>
    </form>
</div>