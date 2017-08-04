<h3>
    Manage your elections
</h3>
<div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>
                    Title
                </th>
                <th>
                    Anonymous?
                </th>
                <th>
                    End Date/Close Manually
                </th>
                <th>
                    Votes Cast
                </th>
                <th>
                    Voting Link
                </th>
                <th>
                    Results Link
                </th>
            </tr>
        </thead>
        <tbody>
            <?php for ($i = 0; $i < $num_elections; $i++): ?>
                <tr>
                    <td>
                        <?= htmlspecialchars($title_array[$i]) ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($anon_array[$i] ? "Yes" : "No") ?>
                    </td>
                    <td>
                        <?php if (!$open_array[$i]): ?>
                            Election closed
                        <?php elseif ($has_end_date_array[$i]): ?>
                            <?= htmlspecialchars($end_date_array[$i]) ?>
                        <?php else: ?>
                            <form action = "close.php" method="post">
                                <input type="hidden" name="election" value=<?= htmlspecialchars($hash_array[$i]) ?> />
                                <input class="btn btn-default" type="submit" value="Close"/>
                            </form>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($num_votes_array[$i]) ?>
                    </td>
                    <td>
                        <?php if (!$open_array[$i]): ?>
                            Voting is closed
                        <?php else: ?>
                            <input type="text" cols="25" onfocus="this.select();" onmouseup="return false;" value=<?= htmlspecialchars($voting_link_array[$i]) ?> />
                            <a class="btn btn-default" href=<?= htmlspecialchars($voting_link_array[$i]) ?> >Go</a>
                        <?php endif; ?>
                    </td>
                    <td>
                        <input type="text" cols="25" onfocus="this.select();" onmouseup="return false;" value=<?= htmlspecialchars($results_link_array[$i]) ?> />
                        <a class="btn btn-default" href=<?= htmlspecialchars($results_link_array[$i]) ?> >Go</a>
                    </td>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>
</div>