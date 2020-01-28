<h1></h1>

<form method="POST" action="#">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="string" class="form-control" id="name" aria-describedby="name" name="name" placeholder="" value="<?= $game["name"];?>">
    </div>
    <div class="form-group">
        <label for="image">Image</label>
        <input type="string" class="form-control" id="image" aria-describedby="image" name="image" placeholder="" value="<?= $game["image"];?>">
    </div>

    <button type="submit" class="btn btn-primary">Save</button>


</form>