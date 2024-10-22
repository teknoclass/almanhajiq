$(document).ready(function () {



    $('.no-select-2').select2();
    if ($('#timeTable tbody tr').length > 0) {

        $('#generate_btn_div').hide();
        $('#add_lesson').show();

    }
    else {
        $('#publish-button').hide();
        $('#btn_submit').hide();
        $('#add_lesson').hide();

    }

});

const days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']

function generateSessionInputs($published) {
    var container = document.getElementById('sessionInputsContainer');
    container.innerHTML = '';
    var numberOfSessions = document.getElementById('weekly_sessions').value;

    for (var i = 1; i <= numberOfSessions; i++) {
        var daySelect = document.createElement('select');
        daySelect.name = 'session_day_' + i;
        daySelect.className = 'form-control mb-2';
        daySelect.innerHTML = `<option>${translations.select_day || 'Select Day'}</option>` + days.map((item, idx) =>
            `<option key=${idx} value="${item}">${translations[item] || item}</option>`
        ).join('')

        daySelect.addEventListener('change', updateDayOptions);

        var timeInput = document.createElement('input');
        timeInput.type = 'time';
        timeInput.name = 'session_time_' + i;
        timeInput.className = 'form-control mb-2';

        daySelect.addEventListener('change', checkAllFieldsFilled);
        timeInput.addEventListener('input', checkAllFieldsFilled);

        var dayCol = document.createElement('div');
        dayCol.className = 'col-md-6';
        dayCol.appendChild(daySelect);

        var timeCol = document.createElement('div');
        timeCol.className = 'col-md-6';
        timeCol.appendChild(timeInput);

        var sessionRow = document.createElement('div');
        sessionRow.className = 'row mb-3';
        sessionRow.appendChild(dayCol);
        sessionRow.appendChild(timeCol);

        container.appendChild(sessionRow);
    }

    checkAllFieldsFilled($published);
}

function checkAllFieldsFilled($published) {
    var daySelects = document.querySelectorAll('select[name^="session_day_"]');
    var timeInputs = document.querySelectorAll('input[name^="session_time_"]');

    var allFieldsFilled = true;

    daySelects.forEach(function (select) {
        if (!select.value) {
            allFieldsFilled = false;
        }
    });

    timeInputs.forEach(function (input) {
        if (!input.value) {
            allFieldsFilled = false;
        }
    });

    var generateBtn = document.getElementById('generate_btn');

    if (allFieldsFilled) {
        generateBtn.style.pointerEvents = 'auto';
        generateBtn.style.opacity = '1';
    } else {
        generateBtn.style.pointerEvents = 'none';
        generateBtn.style.opacity = '0.5';
    }
}


function updateDayOptions() {
    var selectedDays = [];
    var daySelects = document.querySelectorAll('select[name^="session_day_"]');

    daySelects.forEach(function (select) {
        if (select.value) {
            selectedDays.push(select.value);
        }
    });


    checkAllFieldsFilled();
}


function generatePlan(start_date) {

    console.log("start_date", start_date);
    var planContainer = document.getElementById('planContainer');
    if (!planContainer) {
        console.error('planContainer element not found');
        return;
    }

    var weeklySessions = parseInt(document.getElementById('weekly_sessions').value);
    var totalSessions = parseInt(document.getElementById('total_sessions').value);

    if (totalSessions < weeklySessions) {
        alert('Total sessions must be greater than weekly sessions.');
        return;
    }

    var daySelects = document.querySelectorAll('select[name^="session_day_"]');
    for (var select of daySelects) {
        if (!select.value) {
            alert('Please select all days.');
            return;
        }
    }

    planContainer.innerHTML = '';

    var startingDate = new Date(start_date.split(' ')[0]);

    var table = document.createElement('table');
    table.className = 'table table-bordered';
    var thead = document.createElement('thead');
    thead.innerHTML = `
        <tr>
            <th>${translations.day || 'Day'}</th>
            <th>${translations.date || 'Date'}</th>
            <th>${translations.time || 'Time'}</th>
            <th>${translations.session_title || 'Session Title'}</th>
            <th>${translations.actions || 'Actions'}</th>
        </tr>
    `;
    table.appendChild(thead);

    var tbody = document.createElement('tbody');
    var fragment = document.createDocumentFragment();

    var selectedDays = Array.from(daySelects).map(select => select.value);
    var currentDayIndex = 0;

    for (var i = 0; i < totalSessions; i++) {
        var row = document.createElement('tr');

        var dayCell = document.createElement('td');
        var dateCell = document.createElement('td');
        var timeCell = document.createElement('td');
        var titleCell = document.createElement('td');
        var actionCell = document.createElement('td');

        let dayInputDisplay = document.createElement('input');
        dayInputDisplay.type = 'text';
        dayInputDisplay.name = 'session_day_display_' + i;
        dayInputDisplay.className = 'form-control session_day';
        dayInputDisplay.readOnly = true
        dayInputDisplay.disabled = true
        dayInputDisplay.value = translations[selectedDays[currentDayIndex % weeklySessions]] || selectedDays[currentDayIndex % weeklySessions];
        dayInputDisplay.placeholder = translations[selectedDays[currentDayIndex % weeklySessions]] || selectedDays[currentDayIndex % weeklySessions];

        let dayInputHidden = document.createElement('input');
        dayInputHidden.type = 'hidden';
        dayInputHidden.name = 'session_day_' + i;
        dayInputHidden.value = selectedDays[currentDayIndex % weeklySessions];

        dayCell.appendChild(dayInputDisplay);
        dayCell.appendChild(dayInputHidden);

        var sessionDate = getNextDate(startingDate, dayInputHidden.value);
        startingDate = sessionDate;
        startingDate = sessionDate;


        let dateInput = document.createElement('input');
        dateInput.type = 'date';
        dateInput.name = 'session_date_' + i;
        dateInput.className = 'form-control';
        dateInput.required = true;
        dateInput.value = formatDate(sessionDate);
        dateCell.appendChild(dateInput);





        var timeInput = document.createElement('input');
        timeInput.type = 'time';
        timeInput.name = 'session_time_' + i;
        timeInput.className = 'form-control';
        dateInput.required = true;
        timeInput.value = document.querySelector(`input[name="session_time_${(currentDayIndex % weeklySessions) + 1}"]`).value;
        timeCell.appendChild(timeInput);

        var titleInput = document.createElement('input');
        titleInput.type = 'text';
        titleInput.name = 'session_title_' + i;
        titleInput.className = 'form-control';
        dateInput.required = true;
        titleInput.required = true;
        titleCell.appendChild(titleInput);

        var deleteButton = document.createElement('button');
        deleteButton.type = 'button';
        deleteButton.className = 'btn btn-danger';
        deleteButton.innerHTML = translations.delete || "Delete";
        deleteButton.onclick = function () {
            deleteSession(this);
        };
        actionCell.appendChild(deleteButton);

        row.appendChild(dayCell);
        row.appendChild(dateCell);
        row.appendChild(timeCell);
        row.appendChild(titleCell);
        row.appendChild(actionCell);

        fragment.appendChild(row);

        currentDayIndex++;
    }

    tbody.appendChild(fragment);
    table.appendChild(tbody);
    planContainer.appendChild(table);
    $('#generate_btn_div').hide();
    $('#publish-button').show();
    $('#btn_submit').show();
    $('#add_lesson').show();

}
document.getElementById('planContainer').addEventListener('change', function (event) {
    if (event.target && event.target.type === 'date') {
        const dateInput = event.target;
        console.log('Date changed:', dateInput.value);

        const newDate = new Date(dateInput.value);
        let newDay = newDate.getDay() - 1;

        if (newDay < 0) {
            newDay = 6;
        }

        let row = $(dateInput).closest('tr');

        let dayInputDisplay = row.find('input[name^="session_day_display_"]');
        let dayInputHidden = row.find('input[name^="session_day_"][type="hidden"]');

        dayInputHidden.val(days[newDay]);
        dayInputDisplay.val(translations[days[newDay]] || days[newDay]);

        dayInputDisplay.trigger('change');
    }
});


function deleteSession(data) {
    data.closest('tr').remove();
    console.log($('#timeTable tbody tr').length);
    if ($('#timeTable tbody tr').length === 0) {
        generateSessionInputs(false);
        $('#generate_btn_div').show();
        $('#publish-button').hide();
        $('#btn_submit').hide();
        $('#add_lesson').hide();
    }

}

function getNextDate(startDate, day) {
    var date = new Date(startDate);
    var dayIndex = days.indexOf(day);

    while (date.getDay() !== (dayIndex + 1) % 7) {
        date.setDate(date.getDate() + 1);
    }

    return date;
}

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}


function addNewRow() {
    var planContainer = document.getElementById('planContainer');
    var table = planContainer.querySelector('table');
    var tbody = table.querySelector('tbody');
    var rowCount = tbody.rows.length;

    var row = document.createElement('tr');

    var dayCell = document.createElement('td');
    var dateCell = document.createElement('td');
    var timeCell = document.createElement('td');
    var titleCell = document.createElement('td');
    var actionCell = document.createElement('td');

    var dayInputDisplay = document.createElement('input');
    dayInputDisplay.type = 'text';
    dayInputDisplay.name = 'session_day_display_' + rowCount;
    dayInputDisplay.className = 'form-control';
    dayInputDisplay.readOnly = true;
    dayInputDisplay.required = true;
    dayInputDisplay.disabled = true;
    dayInputDisplay.value = translations[days[0]] || days[0];
    dayInputDisplay.placeholder = translations[days[0]] || days[0];


    var dayInputHidden = document.createElement('input');
    dayInputHidden.type = 'hidden';
    dayInputHidden.name = 'session_day_' + rowCount;
    dayInputHidden.value = days[0];

    dayCell.appendChild(dayInputDisplay);
    dayCell.appendChild(dayInputHidden);

    var dateInput = document.createElement('input');
    dateInput.type = 'date';
    dateInput.name = 'session_date_' + rowCount;
    dateInput.className = 'form-control';
    dateInput.required = true;
    dateCell.appendChild(dateInput);

    var timeInput = document.createElement('input');
    timeInput.type = 'time';
    timeInput.name = 'session_time_' + rowCount;
    timeInput.className = 'form-control';
    timeInput.required = true;
    timeCell.appendChild(timeInput);

    var deleteButton = document.createElement('button');
    deleteButton.type = 'button';
    deleteButton.className = 'btn btn-danger';
    deleteButton.innerHTML = translations.delete || "Delete";
    deleteButton.onclick = function () {
        deleteSession(this);
    };
    var titleInput = document.createElement('input');
    titleInput.type = 'text';
    titleInput.name = 'session_title_' + rowCount;
    titleInput.required = true;
    titleInput.className = 'form-control';
    titleCell.appendChild(titleInput);
    actionCell.appendChild(deleteButton);

    row.appendChild(dayCell);
    row.appendChild(dateCell);
    row.appendChild(timeCell);
    row.appendChild(titleCell);
    row.appendChild(actionCell);

    tbody.appendChild(row);

    generateSessionInputs(true);
    $('#generate_btn_div').hide();
    $('#publish-button').show();
    $('#btn_submit').show();
}



function generateSessionCount() {
    const weeklySessions = document.getElementById('weekly_sessions').value;
    const totalSessionsSelect = document.getElementById('total_sessions');

    totalSessionsSelect.innerHTML = `<option value="" disabled selected>${translations.total_sessions || "Total Session"}</option>`;

    for (let i = parseInt(weeklySessions) + 1; i <= 52; i++) {
        const option = document.createElement('option');
        option.value = i;
        option.text = i;
        totalSessionsSelect.appendChild(option);
    }
}
