<h3>
    Create a new election
</h3>
<form action="new.php" method="post">
    <fieldset>
        <?php for ($i = 1; $i <= $num_candidates; $i++): ?>
        <div class="form-group">
            <label for=<?= "election_candidate" . $i ?> >
                <?= "Candidate " . $i . ":" ?>
            </label>
            <input autocomplete="off" autofocus class="form-control" id=<?= "election_candidate" . $i ?> name=<?= "candidate" . $i ?> placeholder="Name" type="text"/>
        </div>
        <?php endfor; ?>

        <div class="form-group">
            <button class="btn btn-default" type="submit">
                <span aria-hidden="true" class="glyphicon glyphicon-ok-sign"></span>
                Finish
            </button>
        </div>
    </fieldset>
</form>

