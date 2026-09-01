(function () {
    'use strict';

    function copyText(textarea) {
        if (navigator.clipboard && window.isSecureContext) {
            return navigator.clipboard.writeText(textarea.value);
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
    if (examinationDate) {
        examinationDate.addEventListener('change', function () {
            slopeDates.forEach(function (field) {
                field.max = examinationDate.value;
            });
        });
    }

    var chronicity = document.getElementById('chronicity');
    var repeatDate = document.getElementById('repeat_date');
    function updateRepeatDateRequirement() {
        if (chronicity && repeatDate) {
            repeatDate.required = chronicity.value === 'unconfirmed';
        }
    }
    if (chronicity) {
        chronicity.addEventListener('change', updateRepeatDateRequirement);
        updateRepeatDateRequirement();
    }

    var diabetes = document.querySelector('input[name="diabetes"]');
    var hba1c = document.getElementById('hba1c');
    function updateHba1cRequirement() {
        if (diabetes && hba1c) {
            hba1c.required = diabetes.checked;
        }
    }
    if (diabetes) {
        diabetes.addEventListener('change', updateHba1cRequirement);
        updateHba1cRequirement();
    }

    var ambulatoryForm = document.getElementById('ambulatory-calculator-form');
    if (ambulatoryForm) {
        ambulatoryForm.addEventListener('submit', function (event) {
            var causePicker = document.getElementById('mkch10-cause-picker');
            var causeNote = document.getElementById('cause_note');
            var causeStatus = document.getElementById('cause_diagnosis_status');
            var causeSearch = document.getElementById('cause_diagnosis_search');
            var hasCauseCodes = causePicker && causePicker.querySelector('input[name="cause_diagnoses[]"]');
            var hasCauseNote = causeNote && causeNote.value.trim() !== '';
            if (hasCauseCodes || hasCauseNote) {
                return;
            }

            event.preventDefault();
            if (causeStatus) {
                causeStatus.textContent = 'Uveďte príčinu CKD výberom z číselníka MKCH-10 alebo vlastným textom.';
            }
            if (causeSearch && !causeSearch.disabled) {
                causeSearch.focus();
            } else if (causeNote) {
                causeNote.focus();
            }
        });
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
})();
