(function () {
    'use strict';

    function copyText(textarea) {
        if (navigator.clipboard && window.isSecureContext) {
            // Textarea normalizuje konce riadkov na LF; DOS a Nefris očakávajú CRLF.
            return navigator.clipboard.writeText(textarea.value.replace(/\r?\n/g, '\r\n'));
        }

        return new Promise(function (resolve, reject) {
            textarea.focus();
            textarea.select();
            textarea.setSelectionRange(0, textarea.value.length);
            try {
                if (document.execCommand('copy')) {
                    resolve();
                } else {
                    reject(new Error('Kopírovanie nie je podporované.'));
                }
            } catch (error) {
                reject(error);
            }
        });
    }

    var copyButton = document.getElementById('copy-ambulatory-output');
    var output = document.getElementById('ambulatory-output');
    var copyStatus = document.getElementById('ambulatory-copy-status');

    if (copyButton && output && copyStatus) {
        copyButton.addEventListener('click', function () {
            copyText(output).then(function () {
                copyStatus.textContent = 'Text bol skopírovaný.';
                copyButton.textContent = 'Skopírované';
                window.setTimeout(function () {
                    copyButton.textContent = 'Skopírovať text';
                    copyStatus.textContent = '';
                }, 2500);
            }).catch(function () {
                copyStatus.textContent = 'Kopírovanie zlyhalo. Označte text a skopírujte ho ručne.';
            });
        });
    }

    var examinationDate = document.getElementById('examination_date');
    var slopeDates = document.querySelectorAll('[id^="slope_date_"]');
    var birthInput = document.getElementById('birth_input');
    var birthAgeStatus = document.getElementById('birth_age_status');

    function parseBirthInput(raw) {
        var normalized = String(raw || '').trim().replace(/[\s\u00a0]+/g, '').replace(/[–—\\]/g, '-');
        if (!normalized) {
            return null;
        }

        var year = 0;
        var month = 1;
        var day = 1;
        var match;

        if ((match = /^(\d{4})$/.exec(normalized))) {
            year = Number.parseInt(match[1], 10);
        } else if ((match = /^(\d{4})[.\/-](\d{1,2})$/.exec(normalized))) {
            year = Number.parseInt(match[1], 10);
            month = Number.parseInt(match[2], 10);
        } else if ((match = /^(\d{1,2})[.\/-](\d{4})$/.exec(normalized))) {
            year = Number.parseInt(match[2], 10);
            month = Number.parseInt(match[1], 10);
        } else if ((match = /^(\d{4})[.\/-](\d{1,2})[.\/-](\d{1,2})$/.exec(normalized))) {
            year = Number.parseInt(match[1], 10);
            month = Number.parseInt(match[2], 10);
            day = Number.parseInt(match[3], 10);
        } else if ((match = /^(\d{1,2})[.\/-](\d{1,2})[.\/-](\d{4})$/.exec(normalized))) {
            year = Number.parseInt(match[3], 10);
            month = Number.parseInt(match[2], 10);
            day = Number.parseInt(match[1], 10);
        } else {
            return null;
        }

        if (year < 1880 || year > 2100 || month < 1 || month > 12 || day < 1 || day > 31) {
            return null;
        }
        var daysInMonth = new Date(year, month, 0).getDate();
        if (day > daysInMonth) {
            return null;
        }

        return {year: year, month: month, day: day};
    }

    function yearsWord(years) {
        if (years === 1) {
            return 'rok';
        }
        var mod100 = years % 100;
        var mod10 = years % 10;
        if (mod10 >= 2 && mod10 <= 4 && (mod100 < 12 || mod100 > 14)) {
            return 'roky';
        }
        return 'rokov';
    }

    function ageAtExamination(birth, examValue) {
        var examParts = /^(\d{4})-(\d{2})-(\d{2})$/.exec(examValue);
        if (!examParts) {
            return null;
        }
        var examYear = Number.parseInt(examParts[1], 10);
        var examMonth = Number.parseInt(examParts[2], 10);
        var examDay = Number.parseInt(examParts[3], 10);
        var age = examYear - birth.year;
        if (examMonth < birth.month || (examMonth === birth.month && examDay < birth.day)) {
            age--;
        }
        return age;
    }

    function updateBirthAgeStatus() {
        if (!birthAgeStatus) {
            return;
        }
        var raw = birthInput ? birthInput.value.trim() : '';
        if (raw === '') {
            birthAgeStatus.textContent = '';
            return;
        }
        var birth = parseBirthInput(raw);
        if (!birth) {
            birthAgeStatus.textContent = 'Dátum narodenia je neplatný.';
            return;
        }
        var examValue = examinationDate ? examinationDate.value : '';
        var age = ageAtExamination(birth, examValue);
        if (age === null) {
            birthAgeStatus.textContent = 'Vek sa dopočíta po zadaní dátumu vyšetrenia.';
            return;
        }
        if (age < 0) {
            birthAgeStatus.textContent = 'Dátum narodenia je po dátume vyšetrenia.';
            return;
        }
        birthAgeStatus.textContent = 'Vek k dátumu vyšetrenia: ' + age + ' ' + yearsWord(age) + '.';
    }

    if (examinationDate) {
        examinationDate.addEventListener('change', function () {
            slopeDates.forEach(function (field) {
                field.max = examinationDate.value;
            });
            updateBirthAgeStatus();
        });
    }
    if (birthInput) {
        birthInput.addEventListener('input', updateBirthAgeStatus);
        birthInput.addEventListener('change', updateBirthAgeStatus);
        updateBirthAgeStatus();
    }

    function normalizeDiagnosisText(value) {
        return value.toLocaleLowerCase('sk-SK')
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/\s+/g, ' ')
            .trim();
    }

    function compactDiagnosisCode(value) {
        return value.toLocaleUpperCase('sk-SK').replace(/[^A-Z0-9]/g, '');
    }

    function bindMkch10Picker(picker, diagnosisItems, codebookStatusSuffix) {
        var diagnosisSearch = picker.querySelector('input[type="search"]');
        var diagnosisResults = picker.querySelector('.mkch10-results');
        var diagnosisSelected = picker.querySelector('.mkch10-selected');
        var diagnosisStatus = picker.querySelector('.mkch10-status');
        if (!diagnosisSearch || !diagnosisResults || !diagnosisSelected || !diagnosisStatus) {
            return;
        }

        var fieldName = picker.dataset.fieldName || 'related_diagnoses[]';
        var initiallySelectedDiagnosisCodes = picker.dataset.selected || '';
        var maximumDiagnoses = Number.parseInt(picker.dataset.maxItems || '12', 10);
        var emptyStatus = picker.dataset.emptyStatus || 'Nie je vybraná žiadna diagnóza.';
        var countStatus = picker.dataset.countStatus || 'Vybrané diagnózy';
        var resultIdPrefix = (picker.id || 'mkch10-picker') + '-result-';
        var selectedDiagnoses = new Map();
        var visibleDiagnoses = [];
        var activeDiagnosisIndex = -1;

        function setDiagnosisResultsOpen(open) {
            diagnosisResults.hidden = !open;
            diagnosisSearch.setAttribute('aria-expanded', open ? 'true' : 'false');
        }

        function updateDiagnosisValue() {
            diagnosisStatus.textContent = selectedDiagnoses.size === 0
                ? emptyStatus
                : countStatus + ': ' + selectedDiagnoses.size + ' z ' + maximumDiagnoses + '.';
        }

        function renderSelectedDiagnoses() {
            diagnosisSelected.replaceChildren();

            selectedDiagnoses.forEach(function (name, code) {
                var item = document.createElement('span');
                item.className = 'mkch10-chip';

                var label = document.createElement('span');
                label.textContent = code + ' – ' + name;
                item.appendChild(label);

                var formValue = document.createElement('input');
                formValue.type = 'hidden';
                formValue.name = fieldName;
                formValue.value = code;
                formValue.setAttribute('value', code);
                item.appendChild(formValue);

                var removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.className = 'mkch10-chip__remove';
                removeButton.textContent = '×';
                removeButton.setAttribute('aria-label', 'Odstrániť diagnózu ' + code);
                removeButton.addEventListener('click', function () {
                    selectedDiagnoses.delete(code);
                    renderSelectedDiagnoses();
                    updateDiagnosisValue();
                    diagnosisSearch.focus();
                });
                item.appendChild(removeButton);
                diagnosisSelected.appendChild(item);
            });
        }

        function selectDiagnosis(item) {
            if (selectedDiagnoses.has(item.code)) {
                diagnosisStatus.textContent = 'Diagnóza ' + item.code + ' už je vybraná.';
                return;
            }
            if (selectedDiagnoses.size >= maximumDiagnoses) {
                diagnosisStatus.textContent = 'Možno vybrať najviac ' + maximumDiagnoses + ' diagnóz.';
                return;
            }

            selectedDiagnoses.set(item.code, item.name);
            diagnosisSearch.value = '';
            visibleDiagnoses = [];
            activeDiagnosisIndex = -1;
            setDiagnosisResultsOpen(false);
            renderSelectedDiagnoses();
            updateDiagnosisValue();
            diagnosisSearch.focus();
        }

        function renderDiagnosisResults() {
            diagnosisResults.replaceChildren();

            if (visibleDiagnoses.length === 0) {
                var empty = document.createElement('div');
                empty.className = 'mkch10-results__empty';
                empty.textContent = 'Nenašli sa zodpovedajúce diagnózy.';
                diagnosisResults.appendChild(empty);
                setDiagnosisResultsOpen(true);
                return;
            }

            visibleDiagnoses.forEach(function (item, index) {
                var option = document.createElement('button');
                option.type = 'button';
                option.className = 'mkch10-result';
                option.id = resultIdPrefix + index;
                option.setAttribute('role', 'option');
                option.setAttribute('aria-selected', index === activeDiagnosisIndex ? 'true' : 'false');

                var code = document.createElement('strong');
                code.textContent = item.code;
                option.appendChild(code);

                var name = document.createElement('span');
                name.textContent = item.name;
                option.appendChild(name);

                option.addEventListener('click', function () {
                    selectDiagnosis(item);
                });
                diagnosisResults.appendChild(option);
            });

            setDiagnosisResultsOpen(true);
            if (activeDiagnosisIndex >= 0) {
                diagnosisSearch.setAttribute('aria-activedescendant', resultIdPrefix + activeDiagnosisIndex);
            } else {
                diagnosisSearch.removeAttribute('aria-activedescendant');
            }
        }

        function searchDiagnoses() {
            var query = normalizeDiagnosisText(diagnosisSearch.value);
            var compactQuery = compactDiagnosisCode(diagnosisSearch.value);
            activeDiagnosisIndex = -1;

            if (query.length < 2 || diagnosisItems.length === 0) {
                visibleDiagnoses = [];
                setDiagnosisResultsOpen(false);
                diagnosisSearch.removeAttribute('aria-activedescendant');
                return;
            }

            visibleDiagnoses = diagnosisItems.filter(function (item) {
                return !selectedDiagnoses.has(item.code) && (
                    item.search.includes(query) || item.compactCode.startsWith(compactQuery)
                );
            }).sort(function (left, right) {
                var leftStarts = left.normalizedCode.startsWith(query) || left.compactCode.startsWith(compactQuery);
                var rightStarts = right.normalizedCode.startsWith(query) || right.compactCode.startsWith(compactQuery);
                if (leftStarts !== rightStarts) {
                    return leftStarts ? -1 : 1;
                }
                return left.code.localeCompare(right.code, 'sk-SK', {numeric: true});
            }).slice(0, 12);

            renderDiagnosisResults();
        }

        diagnosisSearch.addEventListener('input', searchDiagnoses);
        diagnosisSearch.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                setDiagnosisResultsOpen(false);
                diagnosisSearch.removeAttribute('aria-activedescendant');
                return;
            }
            if (!['ArrowDown', 'ArrowUp', 'Enter'].includes(event.key) || visibleDiagnoses.length === 0) {
                return;
            }

            event.preventDefault();
            if (event.key === 'ArrowDown') {
                activeDiagnosisIndex = Math.min(activeDiagnosisIndex + 1, visibleDiagnoses.length - 1);
            } else if (event.key === 'ArrowUp') {
                activeDiagnosisIndex = Math.max(activeDiagnosisIndex - 1, 0);
            } else if (activeDiagnosisIndex >= 0) {
                selectDiagnosis(visibleDiagnoses[activeDiagnosisIndex]);
                return;
            }
            renderDiagnosisResults();
        });
        diagnosisSearch.addEventListener('blur', function () {
            window.setTimeout(function () {
                var active = document.activeElement;
                if (active === diagnosisSearch || diagnosisResults.contains(active)) {
                    return;
                }
                setDiagnosisResultsOpen(false);
            }, 100);
        });

        var index = new Map(diagnosisItems.map(function (item) {
            return [item.code, item];
        }));
        initiallySelectedDiagnosisCodes.split(',').map(function (code) {
            return code.trim().toLocaleUpperCase('sk-SK');
        }).filter(Boolean).forEach(function (code) {
            if (index.has(code) && selectedDiagnoses.size < maximumDiagnoses) {
                selectedDiagnoses.set(code, index.get(code).name);
            }
        });

        renderSelectedDiagnoses();
        updateDiagnosisValue();
        diagnosisStatus.textContent += codebookStatusSuffix;
    }

    var diagnosisPickers = Array.prototype.slice.call(document.querySelectorAll('.mkch10-picker')).filter(function (picker) {
        return picker.querySelector('input[type="search"]');
    });
    var diagnosisSource = '';
    diagnosisPickers.forEach(function (picker) {
        if (!diagnosisSource && picker.dataset.source) {
            diagnosisSource = picker.dataset.source;
        }
    });

    if (diagnosisPickers.length > 0 && diagnosisSource) {
        fetch(diagnosisSource, {headers: {'Accept': 'application/json'}})
            .then(function (response) {
                if (!response.ok) {
                    throw new Error('HTTP ' + response.status);
                }
                return response.json();
            })
            .then(function (data) {
                if (!data || !Array.isArray(data.items)) {
                    throw new Error('Neplatný formát číselníka.');
                }

                var diagnosisItems = data.items.filter(function (item) {
                    return Array.isArray(item) && typeof item[0] === 'string' && typeof item[1] === 'string';
                }).map(function (item) {
                    var code = item[0];
                    var name = item[1];
                    return {
                        code: code,
                        name: name,
                        normalizedCode: normalizeDiagnosisText(code),
                        compactCode: compactDiagnosisCode(code),
                        search: normalizeDiagnosisText(code + ' ' + name)
                    };
                });
                var codebookStatusSuffix = ' Číselník MKCH-10-SK v' +
                    String(data.meta && data.meta.version ? data.meta.version : '') +
                    ' je načítaný.';

                diagnosisPickers.forEach(function (picker) {
                    bindMkch10Picker(picker, diagnosisItems, codebookStatusSuffix);
                });
            })
            .catch(function () {
                diagnosisPickers.forEach(function (picker) {
                    var search = picker.querySelector('input[type="search"]');
                    var status = picker.querySelector('.mkch10-status');
                    if (search) {
                        search.disabled = true;
                    }
                    if (status) {
                        status.textContent = 'Číselník MKCH-10-SK sa nepodarilo načítať. Obnovte stránku.';
                    }
                });
            });
    }
    // Výber laboratórnych výsledkov z Nefrisu: súbor a stiahnutie v CP852 (MS-DOS Latin 2).
    // Znaky pre bajty 0x80 až 0xFF; tools/test_ambulatory_labs.php ich porovnáva s iconv.
    var CP852_HIGH = 'ÇüéâäůćçłëŐőîŹÄĆ' + 'ÉĹĺôöĽľŚśÖÜŤťŁ×č' + 'áíóúĄąŽžĘę¬źČş«»' + '░▒▓│┤ÁÂĚŞ╣║╗╝Żż┐' +
        '└┴┬├─┼Ăă╚╔╩╦╠═╬¤' + 'đĐĎËďŇÍÎě┘┌█▄ŢŮ▀' + 'ÓßÔŃńňŠšŔÚŕŰýÝţ´' + '\u00AD˝˛ˇ˘§÷¸°¨˙űŘř■\u00A0';
    var LABS_MAX_FILE_BYTES = 1024 * 1024;
    var LABS_PREFS_KEY = 'nefro.ambulatory.labs.v1';
    var LABS_PREF_FIELDS = ['labs_selection', 'labs_custom_list', 'labs_dates', 'labs_format', 'labs_item_template',
        'labs_group_template', 'labs_separator', 'labs_width', 'labs_flags', 'labs_ref'];

    function decodeCp852(bytes) {
        var out = '';
        for (var i = 0; i < bytes.length; i++) {
            out += bytes[i] < 128 ? String.fromCharCode(bytes[i]) : CP852_HIGH.charAt(bytes[i] - 128);
        }
        return out;
    }

    function encodeCp852(text) {
        var reverse = {};
        for (var i = 0; i < CP852_HIGH.length; i++) {
            reverse[CP852_HIGH.charAt(i)] = 128 + i;
        }
        var bytes = new Uint8Array(text.length);
        for (var j = 0; j < text.length; j++) {
            var code = text.charCodeAt(j);
            bytes[j] = code < 128 ? code : (reverse[text.charAt(j)] || 63);
        }
        return bytes;
    }

    // Rovnaké skóre ako labsTextScore() v ambulatory_labs.php: slovenské písmená plus,
    // iné znaky mimo ASCII a veľké písmeno uprostred slova mínus, rámčeky DOS neutrálne.
    var SLOVAK_LETTERS = 'áäčďéíĺľňóôŕšťúýžÁÄČĎÉÍĹĽŇÓÔŔŠŤÚÝŽ';
    function textScore(text) {
        var score = 0;
        for (var i = 0; i < text.length; i++) {
            var code = text.charCodeAt(i);
            if (code < 128) {
                continue;
            }
            var char = text.charAt(i);
            if (SLOVAK_LETTERS.indexOf(char) !== -1) {
                score += 2;
            } else if (!(code >= 0x2500 && code <= 0x259F) && char !== '°' && char !== 'µ') {
                score -= 3;
            }
        }
        var mixed = text.match(/[a-záäčďéíĺľňóôŕšťúýž][ÁÄČĎÉÍĹĽŇÓÔŔŠŤÚÝŽ][a-záäčďéíĺľňóôŕšťúýž]/g);
        return score - 4 * (mixed ? mixed.length : 0);
    }

    function decodeLabsFile(bytes, encoding) {
        if (encoding === 'cp852') {
            return {text: decodeCp852(bytes), used: 'CP852'};
        }
        if (encoding === 'auto' || encoding === 'utf-8') {
            try {
                return {text: new TextDecoder('utf-8', {fatal: encoding === 'auto'}).decode(bytes), used: 'UTF-8'};
            } catch (error) {
                // Nie je UTF-8: súbor z Nefrisu býva v CP852, prípadne už prevedený do Windows-1250.
                var dos = decodeCp852(bytes);
                var windows = new TextDecoder('windows-1250').decode(bytes);
                return textScore(windows) > textScore(dos) + 1
                    ? {text: windows, used: 'Windows-1250'}
                    : {text: dos, used: 'CP852'};
            }
        }
        return {text: new TextDecoder(encoding).decode(bytes), used: encoding};
    }

    var labsForm = document.getElementById('labs-form');
    if (labsForm) {
        var labsFileGroup = document.getElementById('labs-file-group');
        var labsFile = document.getElementById('labs_file');
        var labsEncoding = document.getElementById('labs_file_encoding');
        var labsFileStatus = document.getElementById('labs_file_status');
        var labsInput = document.getElementById('labs_input');

        if (labsFileGroup && labsFile && labsInput && window.TextDecoder && window.Uint8Array) {
            labsFileGroup.hidden = false;
            var lastLabsFile = null;
            var readLabsFile = function (file) {
                if (!file) {
                    return;
                }
                lastLabsFile = file;
                if (file.size > LABS_MAX_FILE_BYTES) {
                    labsFileStatus.textContent = 'Súbor je väčší ako 1 MB. Vložte len časť s výsledkami.';
                    return;
                }
                var reader = new FileReader();
                reader.onload = function () {
                    var decoded = decodeLabsFile(new Uint8Array(reader.result), labsEncoding ? labsEncoding.value : 'auto');
                    labsInput.value = decoded.text.replace(/^\uFEFF/, '').replace(/\r\n?/g, '\n');
                    labsFileStatus.textContent = 'Načítané: ' + file.name + ' (kódovanie ' + decoded.used + '). Skontrolujte diakritiku v poli nižšie.';
                };
                reader.onerror = function () {
                    labsFileStatus.textContent = 'Súbor sa nepodarilo načítať.';
                };
                reader.readAsArrayBuffer(file);
            };
            labsFile.addEventListener('change', function () {
                readLabsFile(labsFile.files && labsFile.files[0]);
            });
            if (labsEncoding) {
                labsEncoding.addEventListener('change', function () {
                    readLabsFile(lastLabsFile);
                });
            }
            // Súbor TXT možno pretiahnuť aj priamo do okna s textom.
            labsInput.addEventListener('dragover', function (event) {
                if (event.dataTransfer && Array.prototype.indexOf.call(event.dataTransfer.types || [], 'Files') !== -1) {
                    event.preventDefault();
                    event.dataTransfer.dropEffect = 'copy';
                    labsInput.classList.add('labs-input--drop');
                }
            });
            labsInput.addEventListener('dragleave', function () {
                labsInput.classList.remove('labs-input--drop');
            });
            labsInput.addEventListener('drop', function (event) {
                labsInput.classList.remove('labs-input--drop');
                if (event.dataTransfer && event.dataTransfer.files && event.dataTransfer.files.length > 0) {
                    event.preventDefault();
                    readLabsFile(event.dataTransfer.files[0]);
                }
            });
        }

        var fieldValue = function (name) {
            var field = labsForm.elements[name];
            return field ? field.value : '';
        };
        var toggleLabsFields = function () {
            labsForm.querySelectorAll('[data-labs-show], [data-labs-hide]').forEach(function (element) {
                var show = element.getAttribute('data-labs-show');
                var rule = (show || element.getAttribute('data-labs-hide')).split(':');
                var matches = fieldValue(rule[0]) === rule[1];
                element.hidden = show ? !matches : matches;
            });
        };

        // Vlastný výber a formát si pamätá len tento prehliadač (pohodlie, nie údaje pacienta).
        if (labsForm.getAttribute('data-labs-posted') !== '1') {
            try {
                var saved = JSON.parse(window.localStorage.getItem(LABS_PREFS_KEY) || 'null');
                if (saved && typeof saved === 'object') {
                    LABS_PREF_FIELDS.forEach(function (name) {
                        var field = labsForm.elements[name];
                        if (!field || typeof saved[name] !== 'string') {
                            return;
                        }
                        if (field.type === 'checkbox') {
                            field.checked = saved[name] === '1';
                        } else if (field instanceof RadioNodeList) {
                            field.forEach(function (radio) {
                                radio.checked = radio.value === saved[name];
                            });
                        } else {
                            field.value = saved[name];
                        }
                    });
                }
            } catch (error) {
                // Bez uložených nastavení platia predvolené hodnoty formulára.
            }
        }
        labsForm.addEventListener('submit', function () {
            try {
                var prefs = {};
                LABS_PREF_FIELDS.forEach(function (name) {
                    var field = labsForm.elements[name];
                    if (field) {
                        prefs[name] = field.type === 'checkbox' ? (field.checked ? '1' : '') : field.value;
                    }
                });
                window.localStorage.setItem(LABS_PREFS_KEY, JSON.stringify(prefs));
            } catch (error) {
                // Úložisko prehliadača môže byť vypnuté; formulár sa odošle aj tak.
            }
        });
        labsForm.addEventListener('change', toggleLabsFields);
        toggleLabsFields();
    }

    var labsOutput = document.getElementById('labs-output');
    var labsCopy = document.getElementById('copy-labs-output');
    var labsDownload = document.getElementById('download-labs-output');
    var labsCopyStatus = document.getElementById('labs-copy-status');
    if (labsOutput && labsCopy && labsCopyStatus) {
        labsCopy.addEventListener('click', function () {
            copyText(labsOutput).then(function () {
                labsCopyStatus.textContent = 'Text bol skopírovaný.';
            }).catch(function () {
                labsCopyStatus.textContent = 'Kopírovanie zlyhalo. Označte text a skopírujte ho ručne.';
            });
        });
    }
    if (labsOutput && labsDownload && window.Blob && window.URL && URL.createObjectURL) {
        labsDownload.hidden = false;
        labsDownload.addEventListener('click', function () {
            var text = labsOutput.value.replace(/\r?\n/g, '\r\n') + '\r\n';
            var blob = new Blob([encodeCp852(text)], {type: 'text/plain'});
            var link = document.createElement('a');
            var today = new Date();
            var pad = function (number) {
                return (number < 10 ? '0' : '') + number;
            };
            link.href = URL.createObjectURL(blob);
            link.download = 'laboratorne-vysledky-' + today.getFullYear() + '-' + pad(today.getMonth() + 1) + '-' + pad(today.getDate()) + '.txt';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            window.setTimeout(function () {
                URL.revokeObjectURL(link.href);
            }, 1000);
            labsCopyStatus.textContent = 'Súbor v kódovaní CP852 sa sťahuje.';
        });
    }
})();
