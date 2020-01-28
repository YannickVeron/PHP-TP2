<h1>Last Scores</h1>
<div class="row">
    <div class="col">
        <form class="form-inline" action="/score/add" method="post">
            <label class="sr-only" for="game">Game</label>
            <select class="custom-select mr-sm-3" id="game" name="game" required>
                <option disabled selected>game</option>
                <?php foreach ($games as $game): ?>
                    <option value="<?= $game->getId(); ?>"><?= $game->getName(); ?></option>
                <?php endforeach; ?>
            </select>
            <label class="sr-only" for="player">Player</label>
            <select class="custom-select mr-sm-3" id="player" name="player" required>
                <option disabled selected>player</option>
                <?php foreach ($players as $player): ?>
                    <option value="<?= $player->getId(); ?>"><?= $player->getUsername(); ?></option>
                <?php endforeach; ?>
            </select>
            <label class="sr-only" for="score">Score</label>
            <input type="number" class="form-control mr-sm-3 pull-right" name="score" id="score" placeholder="score" value="0">


            <button type="submit" class=" ml-4 btn btn-primary">Add Score</button>
        </form>
    </div>
</div>
<br/>
<div class="row">
    <table class="table">
        <thead>

        <tr>
            <th class="">#</th>
            <th class="col">user</th>
            <th class="col">game</th>
            <th class="col">score</th>
            <th class="col"></th>

        </tr>
        </thead>
        <tbody>
        <?php foreach ($scores as $score): ?>
            <tr>
                <td><?= $score->getId(); ?></td>
                <td><?= $score->getOwner()->getUsername(); ?></td>
                <td><?= $score->getGame()->getName(); ?></td>
                <td> <?= $score->getScore(); ?></td>
                <td>
                    <a href="/score/delete?id=<?= $score->getId(); ?>"
                       onclick="return confirm('Are you sure you want to delete it?')">
                        <i class="fas fa-trash"></i>
                    </a>

                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>


</div>