<p>
    The election was closed successfully.
</p>
<div>
    <form action="results.php" method="get">
        <input type="hidden" name="election" value=<?= htmlspecialchars($hash) ?> />
        <input class="btn btn-default" type="submit" value="View Results"/>
    </form>
</div>