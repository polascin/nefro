<?php
declare(strict_types=1);
/**
 * Partial: voliteľné pole „Typ používateľa“ pre registráciu aj profil.
 *
 * Očakáva v scope volajúceho premennú $selectedUserType (string|null) — aktuálne zvolenú hodnotu.
 * Možnosti aj ich poradie definuje getUserTypeGroups() v db_config.php (jediný zdroj pravdy).
 */
$selectedUserType = $selectedUserType ?? '';
?>
                        <div class="form-group">
                            <label for="user_type">Typ používateľa <small>(nepovinné)</small></label>
                            <select id="user_type" name="user_type" class="form-control">
                                <option value="">-- Vyberte --</option>
                                <?php foreach (getUserTypeGroups() as $groupLabel => $groupOptions): ?>
                                    <?php if ($groupLabel === ''): ?>
                                        <?php foreach ($groupOptions as $opt): ?>
                                            <option value="<?= htmlspecialchars($opt) ?>" <?= $selectedUserType === $opt ? 'selected' : '' ?>><?= htmlspecialchars($opt) ?></option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <optgroup label="<?= htmlspecialchars($groupLabel) ?>">
                                            <?php foreach ($groupOptions as $opt): ?>
                                                <option value="<?= htmlspecialchars($opt) ?>" <?= $selectedUserType === $opt ? 'selected' : '' ?>><?= htmlspecialchars($opt) ?></option>
                                            <?php endforeach; ?>
                                        </optgroup>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
