let questionIndex = 0;

function addQuestion() {
    const container = document.getElementById("questions-container");

    const questionHTML = `
        <div class="question-group mb-4 border border-light rounded p-3 position-relative" data-index="${questionIndex}">
            <div class="d-flex justify-content-between align-items-start">
                <h5 class="mb-3">Question <span class="question-counter">${
                    questionIndex + 1
                }</span></h5>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeQuestion(this)">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <div class="row align-items-end">
                <div class="col-md-6 mb-2">
                    <label class="form-label">Question*</label>
                    <input type="text" name="questions[${questionIndex}][question]" class="form-control" placeholder="Question" required>
                </div>
                <div class="col-md-2 mb-2">
                    <label class="form-label">Score</label>
                    <input type="number" name="questions[${questionIndex}][score]" class="form-control" value="10" min="10" required>
                </div>
                <div class="col-md-4 mb-2">
                    <label class="form-label">Type*</label>
                    <select name="questions[${questionIndex}][type]" class="form-select question-type" onchange="handleQuestionTypeChange(this)" required>
                        <option value="">Select type</option>
                        <option value="free_text">Free Text</option>
                        <option value="true_false">True or False</option>
                        <option value="multiple_choice">Multiple Choice</option>
                    </select>
                </div>
            </div>

            <div class="row question-extra mt-3"></div>
        </div>
    `;

    container.insertAdjacentHTML("beforeend", questionHTML);
    questionIndex++;
    validateAddButton();
}

function removeQuestion(button) {
    const group = button.closest(".question-group");
    group.remove();
    reindexQuestions();
}

function reindexQuestions() {
    const groups = document.querySelectorAll(".question-group");
    groups.forEach((group, newIndex) => {
        group.dataset.index = newIndex;
        group.querySelector(".question-counter").textContent = newIndex + 1;

        const inputs = group.querySelectorAll("input, select, textarea");
        inputs.forEach((input) => {
            if (input.name) {
                input.name = input.name.replace(
                    /questions\[\d+\]/,
                    `questions[${newIndex}]`
                );
            }
            if (input.id) {
                input.id = input.id.replace(/_(\d+)$/, `_${newIndex}`);
            }
        });

        const radios = group.querySelectorAll('input[type="radio"]');
        radios.forEach((radio, i) => {
            radio.name = `questions[${newIndex}][correct]`;
            radio.value = i;
        });
    });

    questionIndex = groups.length;
    validateAddButton();
}

function handleQuestionTypeChange(select) {
    const group = select.closest(".question-group");
    const index = group.dataset.index;
    const extra = group.querySelector(".question-extra");
    const type = select.value;

    if (type === "free_text") {
        extra.innerHTML = `
            <div class="col-md-6 mb-2">
                <label class="form-label">Model Answer</label>
                <textarea name="questions[${index}][text_answer_model]" class="form-control" rows="3" style="resize: none"></textarea>
            </div>
        `;
    } else if (type === "true_false") {
        extra.innerHTML = `
            <div class="col-md-6 mb-2">
                <div class="form-check mt-2">
                    <input type="hidden" name="questions[${index}][is_true]" value="0">
                    <input class="form-check-input" type="checkbox" name="questions[${index}][is_true]" value="1" id="is_true_${index}">
                    <label class="form-check-label" for="is_true_${index}">This statement is correct</label>
                </div>
            </div>

        `;
    } else if (type === "multiple_choice") {
        extra.innerHTML = `
            <div class="col-12">
                <label class="form-label d-block">Options</label>
                <div data-options-wrapper class="d-flex flex-column gap-2" style="max-width: 600px;"></div>
                <small class="text-muted d-block pt-2">First option is selected as correct by default. Use radio to choose correct answer.</small>
                <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addOption(${index})">+ Add Option</button>
            </div>
        `;
        addOption(index);
    } else {
        extra.innerHTML = "";
    }

    validateAddButton();
}

function addOption(index) {
    const group = document.querySelector(
        `.question-group[data-index="${index}"]`
    );
    const wrapper = group.querySelector("[data-options-wrapper]");
    const count = wrapper.querySelectorAll(".mc-option").length;

    const optionHTML = `
        <div class="input-group mc-option" style="max-width: 500px;">
            <div class="input-group-text">
                <input type="radio" name="questions[${index}][correct]" value="${count}" ${
        count === 0 ? "checked" : ""
    }>
            </div>
            <input type="text" name="questions[${index}][options][]" class="form-control" placeholder="Option text" required>
            <button type="button" class="btn btn-sm btn-danger" onclick="removeOption(this)"><i class="bi bi-x-lg"></i></button>
        </div>
    `;
    wrapper.insertAdjacentHTML("beforeend", optionHTML);
}

function removeOption(button) {
    const wrapper = button.closest("[data-options-wrapper]");
    button.closest(".mc-option").remove();
}

function validateAddButton() {
    const addButton = document.getElementById("add-question-btn");
    const questions = document.querySelectorAll(".question-group");

    if (questions.length === 0) {
        addButton.disabled = false;
        return;
    }

    let allValid = true;
    questions.forEach((group) => {
        const questionInput = group.querySelector('input[name*="[question]"]');
        const typeSelect = group.querySelector('select[name*="[type]"]');

        if (!questionInput.value.trim() || !typeSelect.value) {
            allValid = false;
        }
    });

    addButton.disabled = !allValid;
}

document.addEventListener("DOMContentLoaded", () => {
    addQuestion();
});

window.addQuestion = addQuestion;
window.removeQuestion = removeQuestion;
window.handleQuestionTypeChange = handleQuestionTypeChange;
window.addOption = addOption;
window.removeOption = removeOption;
