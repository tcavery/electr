<h3>
    Results for <?= htmlspecialchars($election_title) ?>
</h3>

<div>
    <?php if ($open): ?>
        Voting is still open. The results so far are as follows:
    <?php elseif($tied): ?>
        The election is now closed, and there was a tie. The joint winners were: 
        <b>
            <?php for($i = 0; $i < count($winners) - 2; $i++ ): ?>
                <?= htmlspecialchars($candidate_names[$winners[$i]] . ", ") ?>
            <?php endfor; ?>
            <?=htmlspecialchars($candidate_names[$winners[count($winners) - 2]]) ?> and <?=htmlspecialchars($candidate_names[$winners[count($winners) - 1]] . ".") ?>
        </b>
    <?php else: ?>
        The election is now closed. The winner is <b><?= htmlspecialchars($candidate_names[$winners[0]]) ?>.</b>
    <?php endif; ?>
</div>

<!-- insert space here -->

<div>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>
                Candidate:
            </th>
            <?php for ($i = 0; $i < $num_candidates; $i++): ?>
            <th>
                <?=htmlspecialchars($candidate_names[$i])?>
            </th>
        <?php endfor;?>
        </tr>
        </thead>
        <tbody>
            <?php if(!$anon): ?>
                <?php for($j = 0; $j < $num_votes; $j++ ): ?>
                    <tr>
                        <td>
                            <?= htmlspecialchars($voter_names[$j]) ?>
                        </td>
                        <?php for ($i = 0; $i < $num_candidates; $i++): ?>
                            <td>
                                <?php if ($vote_matrix[$i][$j] == 1): ?>
                                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                <?php endif; ?>
                            </td>
                        <?php endfor; ?>
                    </tr>
                <?php endfor; ?>
            <?php endif; ?>
            <tr>
                <th>
                    Total votes:
                </th>
                <?php for ($i = 0; $i < $num_candidates; $i++): ?>
                    <td>
                        <?=htmlspecialchars($vote_totals[$i]) ?>
                    </td>
                <?php endfor;?>
            </tr>
        </tbody>
    </table>
</div>