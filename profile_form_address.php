<?php /* Uses $user, $pdo from calling scope */ ?>
                <div class="form-section">
                    <h3>Adresa</h3>
                    <?php
                    $addrCountries      = getCountries($pdo);
                    $addrRegions        = getRegions($pdo);
                    $addrDistricts      = getDistricts($pdo);
                    $addrMunicipalities = getMunicipalitiesWithZip($pdo);
                    $addrZips           = getZipCodes($pdo);
                    ?>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="street">Ulica</label>
                            <input type="text" id="street" name="street" class="form-control"
                                value="<?= htmlspecialchars($user['street'] ?? '') ?>"
                                placeholder="napr. Hlavná"
                                autocomplete="address-line1">
                        </div>
                        <div class="form-group">
                            <label for="house_number">Popisné číslo</label>
                            <input type="text" id="house_number" name="house_number" class="form-control"
                                value="<?= htmlspecialchars($user['house_number'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="orientation_number">Orientačné číslo</label>
                            <input type="text" id="orientation_number" name="orientation_number" class="form-control"
                                value="<?= htmlspecialchars($user['orientation_number'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="city">Obec</label>
                            <input type="text" id="city" name="city" class="form-control"
                                list="city_list"
                                value="<?= htmlspecialchars($user['city'] ?? '') ?>"
                                placeholder="napr. Bratislava"
                                autocomplete="address-level2">
                            <datalist id="city_list">
                                <?php foreach ($addrMunicipalities as $m): ?>
                                    <option value="<?= htmlspecialchars($m['name']) ?>"
                                        data-zip="<?= htmlspecialchars($m['zip_code']) ?>"
                                        data-district="<?= htmlspecialchars($m['district_name']) ?>"
                                        data-region="<?= htmlspecialchars(getRegionNameByCode($pdo, $m['region_code'])) ?>">
                                <?php endforeach; ?>
                            </datalist>
                            <small class="avatar-upload-hint">Výberom obce sa automaticky doplní PSČ, okres a kraj.</small>
                        </div>
                        <div class="form-group">
                            <label for="zip_code">PSČ</label>
                            <input type="text" id="zip_code" name="zip_code" class="form-control"
                                list="zip_list"
                                value="<?= htmlspecialchars($user['zip_code'] ?? '') ?>"
                                placeholder="napr. 81101"
                                maxlength="6" autocomplete="postal-code">
                            <datalist id="zip_list">
                                <?php foreach ($addrZips as $z): ?>
                                    <option value="<?= htmlspecialchars($z) ?>">
                                <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="form-group">
                            <label for="district">Okres</label>
                            <input type="text" id="district" name="district" class="form-control"
                                list="district_list"
                                value="<?= htmlspecialchars($user['district'] ?? '') ?>"
                                placeholder="napr. Bratislava I"
                                autocomplete="off">
                            <datalist id="district_list">
                                <?php foreach ($addrDistricts as $d): ?>
                                    <option value="<?= htmlspecialchars($d) ?>">
                                <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="form-group">
                            <label for="region">Kraj</label>
                            <input type="text" id="region" name="region" class="form-control"
                                list="region_list"
                                value="<?= htmlspecialchars($user['region'] ?? '') ?>"
                                placeholder="napr. Bratislavský kraj"
                                autocomplete="off">
                            <datalist id="region_list">
                                <?php foreach ($addrRegions as $r): ?>
                                    <option value="<?= htmlspecialchars($r) ?>">
                                <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="form-group">
                            <label for="country">Štát</label>
                            <input type="text" id="country" name="country" class="form-control"
                                list="country_list"
                                value="<?= htmlspecialchars($user['country'] ?? '') ?>"
                                placeholder="napr. Slovenská republika"
                                autocomplete="country-name">
                            <datalist id="country_list">
                                <?php foreach ($addrCountries as $c): ?>
                                    <option value="<?= htmlspecialchars($c) ?>">
                                <?php endforeach; ?>
                            </datalist>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address_note">Poznámka k adrese</label>
                        <input type="text" id="address_note" name="address_note" class="form-control"
                            value="<?= htmlspecialchars($user['address_note'] ?? '') ?>">
                    </div>
                </div>
