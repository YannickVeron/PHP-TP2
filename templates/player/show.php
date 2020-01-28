<div class="row">
    <h1><?= $player->getUsername(); ?>
        <small><?= $player->getEmail(); ?></small>
    </h1>
</div>
<div class="row">
    <form class="form-inline" method="post" action="/player/addgame?id=<?= $player->getId(); ?>">

        <label class="sr-only" for="game">Game</label>
        <select class="custom-select mr-sm-3" id="game" name="game_id" required>
            <option disabled selected>game</option>
            <?php foreach ($availableGames as $game): ?>
                <option value="<?= $game->getId(); ?>"><?= $game->getName(); ?></option>
            <?php endforeach; ?>
        </select>


        <button type="submit" class=" ml-4 btn btn-primary">Add Game</button>
    </form>


</div>
<hr/>
<div class="row">
    <?php foreach ($player->getGames() as $game): ?>
        <div class="col-3" style="margin-bottom: 16px;">
            <a href="/game/show?id=<?= $game->getId(); ?>"><img class="img-responsive" src="<?= $game->getImage(); ?>"/></a>
        </div>
    <?php endforeach; ?>
</div>