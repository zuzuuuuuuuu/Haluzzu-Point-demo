<form method="GET" action="<?= $base_url ?>/search-studios">
    <div class="row g-2">
        <div class="col-md-10">
            <div class="row g-2">
                <div class="col-md-6">
                    <input
                        type="text"
                        class="form-control"
                        id="name"
                        name="location"
                        placeholder="Search location"
                        value="<?= isset($_GET['location']) ? htmlspecialchars($_GET['location']) : '' ?>">
                </div>
                <div class="col-md-3">
                    <div class="">
                        <select class="form-select" id="select1" name="studio_type">
                            <option value="" <?= empty($_GET['studio_type']) ? 'selected' : '' ?>>All Type</option>
                            <option value="Apartment" <?= (isset($_GET['studio_type']) && $_GET['studio_type'] == 'Apartment') ? 'selected' : '' ?>>Apartment</option>
                            <option value="Condominium" <?= (isset($_GET['studio_type']) && $_GET['studio_type'] == 'Condominium') ? 'selected' : '' ?>>Condominium</option>
                            <option value="Flat" <?= (isset($_GET['studio_type']) && $_GET['studio_type'] == 'Flat') ? 'selected' : '' ?>>Flat</option>
                            <option value="Semi-D" <?= (isset($_GET['studio_type']) && $_GET['studio_type'] == 'Semi-D') ? 'selected' : '' ?>>Semi-D</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <input
                            type="number"
                            class="form-control"
                            placeholder="Min Price"
                            name="min_price"
                            aria-label="Minimum Price"
                            value="<?= isset($_GET['min_price']) ? htmlspecialchars($_GET['min_price']) : '' ?>">
                        <span class="input-group-text">-</span>
                        <input
                            type="number"
                            class="form-control"
                            placeholder="Max Price"
                            name="max_price"
                            aria-label="Maximum Price"
                            value="<?= isset($_GET['max_price']) ? htmlspecialchars($_GET['max_price']) : '' ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100" type="submit" name="search-studios">Submit</button>
        </div>
    </div>
</form>