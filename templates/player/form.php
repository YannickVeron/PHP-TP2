<h1></h1>

<form method="POST" action="#">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="string" class="form-control" id="username" name="username" aria-describedby="username" placeholder="" value="<?= isset($player)?$player->getUsername():'';?>">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="string" class="form-control" id="email" name="email" aria-describedby="email" placeholder="" value="<?= isset($player)?$player->getEmail():'';?>">
    </div>

    <button type="submit" class="btn btn-primary">Save</button>


</form>