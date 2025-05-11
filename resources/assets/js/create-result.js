document.addEventListener("DOMContentLoaded", function () {
    const steps = document.querySelectorAll(".step");
    const progressBar = document.getElementById("progressBar");
    const form = document.getElementById("assessmentForm");
    const timerEl = document.getElementById("timer");
    let currentStep = 0;
    let isFormSubmitted = false;
    const openConfirmModalBtn = document.getElementById("openConfirmModal");
    const confirmSubmitBtn = document.getElementById("confirmSubmitBtn");
    const questionsStatus = document.getElementById("questionsStatus"); // New

    function showStep(index) {
        steps.forEach((step, i) => {
            step.style.display = i === index ? "block" : "none";
        });

        const progress = ((index + 1) / steps.length) * 100;
        if (progressBar) {
            progressBar.style.width = `${progress}%`;
        }
    }

    document.querySelectorAll(".next-btn").forEach((btn) => {
        btn.addEventListener("click", () => {
            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            }
        });
    });

    document.querySelectorAll(".prev-btn").forEach((btn) => {
        btn.addEventListener("click", () => {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        });
    });

    showStep(currentStep);

    if (form) {
        form.addEventListener("submit", function (e) {
            isFormSubmitted = true;

            const inputs = form.querySelectorAll(
                'input[type="hidden"][name^="answers["]'
            );
            inputs.forEach((input) => {
                if (!input.value.trim()) {
                    input.remove();
                }
            });
        });
    }

    // Timer
    if (timerEl) {
        const durationSeconds = parseInt(timerEl.dataset.remainingSeconds, 10);
        let timeLeft = durationSeconds;

        const formatTime = (seconds) => {
            const minutes = Math.floor(seconds / 60);
            const secs = seconds % 60;
            return `${String(minutes).padStart(2, "0")}:${String(secs).padStart(
                2,
                "0"
            )}`;
        };

        let timerInterval = setInterval(() => {
            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                timerEl.textContent = "00:00";

                const allInputs = form.querySelectorAll('[name^="answers["]');
                let hasAnswers = false;

                allInputs.forEach((input) => {
                    if (
                        ((input.type === "radio" ||
                            input.type === "checkbox") &&
                            input.checked) ||
                        ((input.type === "text" ||
                            input.type === "hidden" ||
                            input.tagName === "TEXTAREA") &&
                            input.value.trim() !== "")
                    ) {
                        hasAnswers = true;
                    }
                });

                if (!hasAnswers) {
                    const emptyInput = document.createElement("input");
                    emptyInput.type = "hidden";
                    emptyInput.name = "answers[-1]";
                    emptyInput.value = "timed out!";
                    form.appendChild(emptyInput);
                }

                isFormSubmitted = true;
                form.submit();
            } else {
                timerEl.textContent = formatTime(timeLeft--);
            }
        }, 1000);

        timerEl.textContent = formatTime(timeLeft);
    }

    if (openConfirmModalBtn && confirmSubmitBtn && form) {
        openConfirmModalBtn.addEventListener("click", function () {
            // Count how many questions are answered
            const inputs = form.querySelectorAll('[name^="answers["]');
            const answeredQuestionIds = new Set();

            inputs.forEach((input) => {
                if (
                    ((input.type === "radio" || input.type === "checkbox") &&
                        input.checked) ||
                    ((input.type === "text" ||
                        input.type === "hidden" ||
                        input.tagName === "TEXTAREA") &&
                        input.value.trim() !== "")
                ) {
                    const name = input.getAttribute("name");
                    const match = name.match(/answers\[(\d+)\]/);
                    if (match) {
                        answeredQuestionIds.add(match[1]);
                    }
                }
            });

            const answered = answeredQuestionIds.size;
            const total = steps.length;

            if (questionsStatus) {
                questionsStatus.textContent = `You have answered ${answered} of ${total} questions.`;
            }

            const confirmModal = new bootstrap.Modal(
                document.getElementById("confirmSubmitModal")
            );
            confirmModal.show();
        });

        confirmSubmitBtn.addEventListener("click", function () {
            confirmSubmitBtn.disabled = true; // Prevent double submission
            form.submit();
        });
    }
});
