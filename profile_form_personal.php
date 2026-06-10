<?php
declare(strict_types=1); /* Uses $user, $pdo from calling scope */ ?>
                <div class="form-section">
                    <h3>Základné a osobné údaje</h3>

                    <div class="avatar-upload-group">
                        <?php
                        $avatarSrc = !empty($user['avatar_path']) ? htmlspecialchars($user['avatar_path']) : 'img/default-avatar-light.svg'; // Default set by JS later
                        ?>
                        <img src="<?= $avatarSrc ?>" id="avatarPreview" data-is-default="<?= empty($user['avatar_path']) ? 'true' : 'false' ?>" data-original-src="<?= htmlspecialchars($user['avatar_path'] ?? '') ?>" alt="Náhľad avatara" class="avatar-upload-preview">
                        <div>
                            <label for="avatar" class="avatar-upload-label">Profilová fotografia (Avatar)</label>
                            <input type="file" id="avatar" name="avatar" class="form-control" accept="image/jpeg, image/png, image/gif, image/webp">
                            <small class="avatar-upload-hint">Zvoľte nový obrázok, ak chcete zmeniť aktuálny.</small>
                            <?php if (!empty($user['avatar_path'])): ?>
                                <div class="form-check">
                                    <input type="checkbox" id="remove_avatar" name="remove_avatar" value="1" <?= isset($_POST['remove_avatar']) ? 'checked' : '' ?>>
                                    <label for="remove_avatar">Vymazať aktuálny obrázok profilu</label>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="username">Používateľské meno</label>
                        <input type="text" id="username" name="username" class="form-control" value="<?= htmlspecialchars($user['username'] ?? '') ?>" autocomplete="username">
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="gender">Identifikácia (pohlavie)</label>
                            <select id="gender" name="gender" class="form-control">
                                <option value="">-- Vyberte --</option>
                                <option value="Muž" <?= ($user['gender'] ?? '') === 'Muž' ? 'selected' : '' ?>>Muž</option>
                                <option value="Žena" <?= ($user['gender'] ?? '') === 'Žena' ? 'selected' : '' ?>>Žena</option>
                                <option value="Transgender muž" <?= ($user['gender'] ?? '') === 'Transgender muž' ? 'selected' : '' ?>>Transgender muž</option>
                                <option value="Transgender žena" <?= ($user['gender'] ?? '') === 'Transgender žena' ? 'selected' : '' ?>>Transgender žena</option>
                                <option value="Nebinárna osoba" <?= ($user['gender'] ?? '') === 'Nebinárna osoba' ? 'selected' : '' ?>>Nebinárna osoba</option>
                                <option value="Iné" <?= ($user['gender'] ?? '') === 'Iné' ? 'selected' : '' ?>>Iné / Iná identita</option>
                                <option value="Nechcem uviesť" <?= ($user['gender'] ?? '') === 'Nechcem uviesť' ? 'selected' : '' ?>>Nechcem uviesť</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pronouns">Identifikačné zámená (napr. on/jeho)</label>
                            <input type="text" id="pronouns" name="pronouns" class="form-control" value="<?= htmlspecialchars($user['pronouns'] ?? '') ?>" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="title_before">Titul pred menom</label>
                            <?php $titlesBefore = getTitlesBeforeName($pdo); ?>
                            <input type="text" id="title_before" name="title_before" class="form-control"
                                list="title_before_list"
                                value="<?= htmlspecialchars($user['title_before'] ?? '') ?>"
                                placeholder="napr. MUDr. alebo MUDr. doc."
                                autocomplete="off">
                            <datalist id="title_before_list">
                                <?php foreach ($titlesBefore as $t): ?>
                                    <option value="<?= htmlspecialchars($t) ?>">
                                <?php endforeach; ?>
                            </datalist>
                            <small class="avatar-upload-hint">Vyberte zo zoznamu alebo zadajte vlastný titul (prípadne aj kombináciu viacerých).</small>
                        </div>
                        <div class="form-group">
                            <label for="first_name">Prvé (krstné) meno</label>
                            <input type="text" id="first_name" name="first_name" class="form-control" value="<?= htmlspecialchars($user['first_name'] ?? '') ?>" autocomplete="given-name">
                        </div>
                        <div class="form-group">
                            <label for="middle_name">Stredné meno/á</label>
                            <input type="text" id="middle_name" name="middle_name" class="form-control" value="<?= htmlspecialchars($user['middle_name'] ?? '') ?>" autocomplete="additional-name">
                        </div>
                        <div class="form-group">
                            <label for="last_name">Priezvisko</label>
                            <input type="text" id="last_name" name="last_name" class="form-control" value="<?= htmlspecialchars($user['last_name'] ?? '') ?>" autocomplete="family-name">
                        </div>
                        <div class="form-group">
                            <label for="title_after">Titul za menom</label>
                            <?php $titlesAfter = getTitlesAfterName($pdo); ?>
                            <input type="text" id="title_after" name="title_after" class="form-control"
                                list="title_after_list"
                                value="<?= htmlspecialchars($user['title_after'] ?? '') ?>"
                                placeholder="napr. PhD. alebo PhD., MBA"
                                autocomplete="off">
                            <datalist id="title_after_list">
                                <?php foreach ($titlesAfter as $t): ?>
                                    <option value="<?= htmlspecialchars($t) ?>">
                                <?php endforeach; ?>
                            </datalist>
                            <small class="avatar-upload-hint">Vyberte zo zoznamu alebo zadajte vlastný titul (prípadne aj kombináciu viacerých).</small>
                        </div>
                        <div class="form-group">
                            <label for="birth_date">Dátum narodenia</label>
                            <input type="date" id="birth_date" name="birth_date" class="form-control" value="<?= htmlspecialchars($user['birth_date'] ?? '') ?>" autocomplete="bday">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name_note">Poznámka k menu</label>
                        <input type="text" id="name_note" name="name_note" class="form-control" value="<?= htmlspecialchars($user['name_note'] ?? '') ?>">
                    </div>
                </div>
