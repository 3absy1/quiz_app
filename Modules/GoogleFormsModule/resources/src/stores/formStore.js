import { svgIcons } from "../components/icons/SvgIcons";
import { defineStore } from "pinia";
import { toast } from "vue3-toastify";
import { useAuthStore } from "./auth";

export const formStore = defineStore("formStore", {
    state: () => ({
        token: JSON.parse(localStorage.getItem("token")) || null,
        // component data
        formList: [
            {
                formInfo: {
                    section: 1,
                    sectionTitle: "Quiz 1",
                    sectionDescription: null,
                },
                data: [
                    {
                        id: 1, // id answer
                        placeholder: `Option`, // push as it is
                        image: null, // push as it is for now
                        img: null, // push as it is for now
                        label: 1, // push with index +1
                        value: "Option 1", //option
                        showImgIcon: false, // as it is for now
                        showImgAltIcon: false, // as it is for now
                        isCorrect: true, // answer key
                    },
                    {
                        id: 1,
                        placeholder: `Option`,
                        image: null,
                        img: null,
                        label: 2,
                        value: "Option 2",
                        showImgIcon: false,
                        showImgAltIcon: false,
                        isCorrect: false,
                    },
                ],
                // flag to display other button
                addOtherBtn: true, //push as it is
                selectedValue: "Choose", //question_type
                selectedLabel: "Choose", //question_type
                selectedIcon: svgIcons.multipleChoice, //based on type
                questionValue: "Chose the correct Option ?", //question
                questionImg: null, // push as it is for now
                imageFileDataUrl: "", // push as it is for now
                selectedInput: "radio", // choose ->radio, multi -> checkbox,
                required: false, // push as it is for now
                isSelected: false, // push as it is
                regularOptions: [""], // fill it with question options
                answerKeySelected: false, // set with always true
                questionMark: 1, // question mark
                previousSelectedValue: null, // push as it is
            },
        ],
        formSetting: {
            username: true,
            phone:false,
            password: false,
            passwordValue: "",
            userQuestionCountSwitch: false,
            userQuestionCount: 0,
            isOnce: false, //test
            anyTime: true,
            duration: 30,
            specificTime: false,
            examTime: {
                date: "",
                from: "",
                to: "",
                duration: 0,
                durationSwitch: false,
            },
        },
        // end component data

        // id counter
        count: 1,

        // these to filter all option and i use it to  hide the remove btn if i have 1 option
        modalType: {},

        // switch flag file upload
        fileTypes: false,

        // select component
        buttonToolbarPosition: "",
        forceUpdateFlag: true,
        sortableKey: 1,

        quizList: [],

        // un comment on deploy
         baseUrl : `${window.location.origin}`,

        // un comment on local
        //baseUrl: `https://quiz.astra-tech.net`,

        degree: null,
    }),

    getters: {
        getFormList() {
            return this.formList;
        },

        //  options data
        optionValues() {
            return [
                {
                    value: "Choose",
                    label: "Choose",
                    inputType: "radio",
                    placeholder: "Option",
                    icon: svgIcons.multipleChoice,
                },
                {
                    value: "Checkboxes",
                    label: "Multiple Answers",
                    inputType: "checkbox",
                    placeholder: "Option",
                    icon: svgIcons.checkBox,
                },
                {
                    value: "TrueOrFalse",
                    label: "True Or False",
                    inputType: "text",
                    placeholder: "",
                    icon: svgIcons.trueOrFalse,
                },
            ];
        },
        totalPoints() {
            let total = 0;
            this.formList.forEach((element) => {
                if (
                    element.questionMark !== null &&
                    !isNaN(element.questionMark)
                ) {
                    total += parseInt(element.questionMark, 10);
                }
            });

            return isNaN(total) ? "" : total.toString();
        },
    },
    actions: {
        handleSetting(settingOption) {
            // Toggle the setting
            this.formSetting[settingOption] = !this.formSetting[settingOption];

            //  Toggle the nested  setting switch
            if (this.formSetting.specificTime) {
                this.formSetting.examTime[settingOption] =
                    !this.formSetting.examTime[settingOption];
            }

            // Handle specific actions based on the settingOption
            switch (settingOption) {
                case "userQuestionCountSwitch":
                    if (!this.formSetting.userQuestionCountSwitch) {
                        this.formSetting.userQuestionCount = 0;
                    }
                    break;
                case "password":
                    if (!this.formSetting.password) {
                        this.formSetting.passwordValue = "";
                    }
                    break;
                case "anyTime":
                    if (this.formSetting.anyTime) {
                        // If anyTime is selected, deselect specificTime
                        this.formSetting.specificTime = false;
                    }
                    if (!this.formSetting.anyTime) {
                        // If anyTime is selected, deselect specificTime
                        this.formSetting.duration = 0;
                        this.formSetting.examTime.to = 0;
                        this.formSetting.examTime.from = 0;
                        // this.formSetting.examTime.date = 0;
                    }
                    break;
                case "specificTime":
                    if (this.formSetting.specificTime) {
                        // If specificTime is selected, deselect anyTime
                        this.formSetting.anyTime = false;
                        this.formSetting.duration = 0;
                    }
                    break;
                case "durationSwitch":
                    if (!this.formSetting.examTime.durationSwitch) {
                        this.formSetting.examTime.duration = 0;
                    }
                    break;
                default:
                    break;
            }
        },
        handleMarksChange(componentIndex) {
            // Get the input value
            let inputValue = this.getFormList[componentIndex].questionMark;

            // Check if the input is empty or NaN
            if (inputValue === "" || isNaN(inputValue)) {
                this.getFormList[componentIndex].questionMark = 0; // Set to a default value, e.g., 0
            } else {
                // Parse the input value as an integer
                this.getFormList[componentIndex].questionMark = parseInt(
                    inputValue,
                    10,
                );
            }
        },

        handleChooseAnswer(componentIndex, optionIndex) {
            this.getFormList[componentIndex].data.forEach((element, index) => {
                if (index === optionIndex) {
                    element.isCorrect = !element.isCorrect;
                } else {
                    element.isCorrect = false;
                }
            });
        },
        handleMultiAnswer(componentIndex, optionIndex) {
            this.getFormList[componentIndex].data.forEach((element, index) => {
                if (index === optionIndex) {
                    element.isCorrect = !element.isCorrect;
                }
            });
        },
        handleTrueFalseAnswer(componentIndex, optionIndex) {
            this.getFormList[componentIndex].data.forEach((element, index) => {
                if (index === optionIndex) {
                    element.isCorrect = !element.isCorrect;
                } else {
                    element.isCorrect = false;
                }
            });
        },

        toggleAnswerKey(componentIndex) {
            this.formList[componentIndex].answerKeySelected = false;
        },

        answerKey(componentIndex) {
            this.formList[componentIndex].answerKeySelected = true;
        },

        // upload img func
        handleUploadImg(componentIndex, event, type, optionIndex) {
            console.log("uploadImage Work ");
            const fileInput = event.target;
            const file = fileInput.files[0];
            const reader = new FileReader();

            reader.onload = () => {
                if (type === "Question") {
                    // Update the image data URL for the specific option
                    this.getFormList[componentIndex].questionImg = file;
                    this.getFormList[componentIndex].imageFileDataUrl =
                        reader.result;
                } else if (type === "Answer") {
                    this.getFormList[componentIndex].data[optionIndex].image =
                        reader.result;
                    this.getFormList[componentIndex].data[optionIndex].img =
                        file;
                }
            };

            reader.readAsDataURL(file);
            // Reset the file input value after handling the upload
            fileInput.value = ""; // Reset the value of the file input
        },

        // remove Img
        removeOptionImg(componentIndex, optionIndex) {
            if (optionIndex == "Question") {
                console.log("aaaaaaa");
                this.getFormList[componentIndex].imageFileDataUrl = null;
                this.getFormList[componentIndex].questionImg = null;
            } else {
                console.log("bbbb");
                this.formList[componentIndex].data[optionIndex].image = null;
                this.formList[componentIndex].data[optionIndex].img = null;
            }
        },

        updateContent(newContent, title, id) {
            if (title === "question") {
                this.formList[id].questionValue = newContent.target.innerText;
            }
            if (title === "title") {
                this.formList[id].formInfo.sectionTitle =
                    newContent.target.innerText;
            }
            if (title === "description") {
                this.formList[id].formInfo.sectionDescription =
                    newContent.target.innerText;
            }
        },

        // add new form component
        addComponent(componentIndex) {
            const selectedIndex = this.formList.findIndex(
                (item) => item.isSelected,
            );
            // If an item is selected, insert the new component under the selected one
            if (selectedIndex !== -1) {
                this.formList.splice(componentIndex + 1, 0, {
                    formInfo: {
                        section: 1,
                        sectionTitle: "",
                        sectionDescription: "Form Description",
                    },
                    data: [
                        {
                            id: 1,
                            placeholder: `Option`,
                            image: null,
                            img: null,
                            label: 1,
                            value: "abc",
                            showImgIcon: false,
                            showImgAltIcon: false,
                            isCorrect: false,
                        },
                        {
                            id: 1,
                            placeholder: `Option`,
                            image: null,
                            img: null,
                            label: 2,
                            value: "xyz",
                            showImgIcon: false,
                            showImgAltIcon: false,
                            isCorrect: true,
                        },
                    ],
                    // flag to display other button
                    addOtherBtn: true,
                    selectedValue: "Choose",
                    selectedLabel: "Choose",
                    selectedIcon: svgIcons.multipleChoice,
                    questionValue: "qwe",
                    questionImg: null,
                    imageFileDataUrl: "",
                    selectedInput: "radio",
                    required: false,
                    isSelected: false,
                    regularOptions: [""],
                    answerKeySelected: false,
                    questionMark: 1,
                    previousSelectedValue: null,
                });
            } else {
                // If no item is selected, add the new component at the end
                this.formList.push({
                    formInfo: {
                        section: 1,
                        sectionTitle: "",
                        sectionDescription: "Form Description",
                    },
                    data: [
                        {
                            id: 1,
                            placeholder: `Option`,
                            image: null,
                            img: null,
                            label: 1,
                            value: "abc",
                            showImgIcon: false,
                            showImgAltIcon: false,
                            isCorrect: false,
                        },
                        {
                            id: 1,
                            placeholder: `Option`,
                            image: null,
                            img: null,
                            label: 2,
                            value: "xyz",
                            showImgIcon: false,
                            showImgAltIcon: false,
                            isCorrect: true,
                        },
                    ],
                    // flag to display other button
                    addOtherBtn: true,
                    selectedValue: "Choose",
                    selectedLabel: "Choose",
                    selectedIcon: svgIcons.multipleChoice,
                    questionValue: "qwe",
                    questionImg: null,
                    imageFileDataUrl: "",
                    selectedInput: "radio",
                    required: false,
                    isSelected: false,
                    regularOptions: [""],
                    answerKeySelected: false,
                    questionMark: 1,
                    previousSelectedValue: null,
                });
            }
            this.incrementSortableKey();
        },

        //  function to pass the comp id from th component to store
        duplicateComponent(originalIndex) {
            if (originalIndex >= 0 && originalIndex < this.formList.length) {
                // Duplicate the component
                const originalComponent = this.formList[originalIndex];
                const duplicatedArray = JSON.parse(
                    JSON.stringify(originalComponent),
                );

                // Assign a new and unique ID to the duplicated component
                duplicatedArray.data.forEach((item) => {
                    item.id =
                        /* Generate a new unique ID, for example: */ Math.random()
                            .toString(36)
                            .substring(7);
                });

                // Create a new array with the duplicated component
                const newArray = [...this.formList];
                newArray.splice(originalIndex + 1, 0, duplicatedArray);

                // Update the state with the new array
                this.formList = newArray;
                this.incrementSortableKey();
            }
        },

        //  remove Component
        removeComponent(index) {
            // Remove the component at the specified index
            if (index >= 0 && index < this.formList.length) {
                this.formList.splice(index, 1);
                this.incrementSortableKey();
            }
        },
        incrementSortableKey() {
            this.sortableKey += 1;
        },

        selectElement(componentIndex) {
            if (componentIndex >= 0 && componentIndex < this.formList.length) {
                // Reset isSelected property for all items
                this.formList.forEach((item) => {
                    item.isSelected = false;
                });

                // Get a reference to the selected question-comp using the ref
                const selectedQuestionComp = document.getElementById(
                    `comp${componentIndex}`,
                );
                if (selectedQuestionComp) {
                    const rect = selectedQuestionComp?.getBoundingClientRect();
                    if (rect?.top < window.innerHeight - 200) {
                        this.buttonToolbarPosition = Math.max(rect?.top, 50);
                    }
                } else {
                    this.buttonToolbarPosition = window.innerHeight - 100;
                }

                // Set isSelected property for the selected item
                this.formList[componentIndex].isSelected = true;
            } else {
                console.error(`removed`);
            }
        },

        //  Add Option to Chooses & CheckBox & Dropdown
        addOption(optionName, componentId) {
            this.count++;
            this.formList[componentId].data.push({
                id: this.count,
                placeholder: optionName,
                image: null,
                value: "",
                showImgIcon: false,
                showImgAltIcon: false,
                isCorrect: false,
            });
            this.resetOptionIdsAndLabels(componentId);
        },

        // fun to change select box values
        updateSelectedValue(value, icon, componentId, label) {
            this.formList[componentId].selectedValue = value;
            this.formList[componentId].selectedLabel = label;
            this.formList[componentId].selectedIcon = icon;

            const [inputType] = this.optionValues.filter(
                (option) => option.value == value,
            );
            this.formList[componentId].selectedInput = inputType.inputType;
            this.updateQuestionData(componentId);
        },

        // Function to update question data based on selected value
        updateQuestionData(componentId) {
            this.formList[componentId].previousSelectedValue =
                this.previousSelectedValue;

            if (this.previousSelectedValue == "TrueOrFalse") {
                // Previous selection was 'TrueOrFalse'
                this.formList[componentId].data = [
                    {
                        id: 1,
                        placeholder: `Option`,
                        image: null,
                        label: 1,
                        value: "",
                        showImgIcon: false,
                        showImgAltIcon: false,
                        isCorrect: false,
                    },
                    {
                        id: 1,
                        placeholder: `Option`,
                        image: null,
                        label: 2,
                        value: "",
                        showImgIcon: false,
                        showImgAltIcon: false,
                        isCorrect: false,
                    },
                ];
            } else if (this.previousSelectedValue == "Choose") {
                // Previous selection was 'Choose'
                this.handleChooseAnswer(componentId);
            }

            if (this.formList[componentId].selectedValue == "Choose") {
                this.formList[componentId].data = [
                    {
                        id: 1,
                        placeholder: `Option`,
                        image: null,
                        label: 1,
                        value: "",
                        showImgIcon: false,
                        showImgAltIcon: false,
                        isCorrect: false,
                    },
                    {
                        id: 1,
                        placeholder: `Option`,
                        image: null,
                        label: 2,
                        value: "",
                        showImgIcon: false,
                        showImgAltIcon: false,
                        isCorrect: false,
                    },
                ];
                this.handleChooseAnswer(componentId);
            } else if (
                this.formList[componentId].selectedValue == "TrueOrFalse"
            ) {
                this.formList[componentId].data = [
                    {
                        id: 1,
                        placeholder: `true`,
                        image: null,
                        label: 1,
                        value: "True",
                        showImgIcon: false,
                        showImgAltIcon: false,
                        isCorrect: false,
                        icon: svgIcons.trueIcon,
                    },
                    {
                        id: 2,
                        placeholder: `false`,
                        image: null,
                        label: 2,
                        value: "False",
                        showImgIcon: false,
                        showImgAltIcon: false,
                        isCorrect: false,
                        icon: svgIcons.falseIcon,
                    },
                ];
            }

            // Save the current selected value for the next update
            this.previousSelectedValue =
                this.formList[componentId].selectedValue;
        },

        //  Remove Option From Chooses & CheckBox & Dropdown
        removeOption(id, componentId) {
            const indexToRemove = this.formList[componentId].data.findIndex(
                (option) => option.id === id,
            );
            // Remove the option using splice
            this.formList[componentId].data.splice(indexToRemove, 1);

            this.resetOptionIdsAndLabels(componentId);
        },

        // Make The Options Ordered
        resetOptionIdsAndLabels(componentId) {
            const regularOptions = this.formList[componentId].data.filter(
                (option) => option.placeholder === "Option",
            );
            let optionCounter = 0;
            this.formList[componentId].data.forEach((option, index) => {
                if (option.placeholder === "Option") {
                    option.id = index + 1;
                    option.label = ++optionCounter;
                    option.placeholder = "Option";
                }
            });
            this.formList[componentId].regularOptions = regularOptions;
        },

        // change the placeholder od Fields when change the select box
        getSelectedPlaceholder(selectedValue) {
            const selectedOption = this.optionValues.find(
                (option) => option.value === selectedValue,
            );

            return selectedOption ? selectedOption.placeholder : "";
        },

        // handle all dropdown
        handleDropdowns(value, dropdownName) {
            this.dropdowns[dropdownName] = value;
        },

        // required switch
        requiredSwitch(componentId) {
            this.formList[componentId].required =
                !this.formList[componentId].required;
        },

        // fun to handle routes of modal
        openModal(modalType) {
            this.modalType = modalType;
            // Access router and route through the root context
            if (this.modalType === "question") {
                this.$router.push({
                    name: "popup",
                    query: { type: "question", page: "forms" },
                });
            }
        },

        // func to handle sortable comp update the list item after sort
        updateContainerMultipleChoiceOrder(newIndex, oldIndex) {
            // Update the order in the state
            const movedComponent = this.formList[oldIndex];
            this.formList.splice(oldIndex, 1);
            this.formList.splice(newIndex, 0, movedComponent);
        },

        // prepare Data before send it to  api
        prepareFormDataObj(apiData,id) {
            const formDataObj = new FormData();

            // Append formData to formDataObj
            apiData.formData.forEach((formDataItem, index) => {
                Object.entries(formDataItem).forEach(([key, value]) => {
                    if (key === "answers" && Array.isArray(value)) {
                        value.forEach((answer, answerIndex) => {
                            Object.entries(answer).forEach(
                                ([answerKey, answerValue]) => {
                                    formDataObj.append(
                                        `formData[${index}][${key}][${answerIndex}][${answerKey}]`,
                                        answerValue,
                                    );
                                },
                            );
                        });
                    } else if (Array.isArray(value)) {
                        value.forEach((item, subIndex) => {
                            // Check if item is a File object
                            if (item instanceof File) {
                                formDataObj.append(
                                    `formData[${index}][${key}][${subIndex}]`,
                                    item,
                                    item.name,
                                );
                            } else {
                                formDataObj.append(
                                    `formData[${index}][${key}][${subIndex}]`,
                                    item,
                                );
                            }
                        });
                    } else {
                        formDataObj.append(`formData[${index}][${key}]`, value);
                    }
                });
            });
            // Append formSettingData to formDataObj
            Object.entries(apiData.formSettingData).forEach(([key, value]) => {
                if (typeof value === "object" && value !== null) {
                    console.log("if", key, value);
                    Object.entries(value).forEach(([subKey, subValue]) => {
                        formDataObj.append(
                            `formSettingData[${key}][${subKey}]`,
                            subValue,
                        );
                    });
                } else {
                    formDataObj.append(`formSettingData[${key}]`, value);
                }
            });

            // Prepare Form DataObj
            // Call Api
            this.handleCreateQuiz(formDataObj,id);
        },

        prepareFormDataObjWithReturn(apiData) {
            const formDataObj = new FormData();

            // Append formData to formDataObj
            console.log(apiData.formData)
            apiData.formData.forEach((formDataItem, index) => {
                Object.entries(formDataItem).forEach(([key, value]) => {
                    if (key === "answers" && Array.isArray(value)) {
                        value.forEach((answer, answerIndex) => {
                            Object.entries(answer).forEach(
                                ([answerKey, answerValue]) => {
                                    formDataObj.append(
                                        `formData[${index}][${key}][${answerIndex}][${answerKey}]`,
                                        answerValue,
                                    );
                                },
                            );
                        });
                    } else if (Array.isArray(value)) {
                        value.forEach((item, subIndex) => {
                            // Check if item is a File object
                            if (item instanceof File) {
                                formDataObj.append(
                                    `formData[${index}][${key}][${subIndex}]`,
                                    item,
                                    item.name,
                                );
                            } else {
                                formDataObj.append(
                                    `formData[${index}][${key}][${subIndex}]`,
                                    item,
                                );
                            }
                        });
                    } else {
                        formDataObj.append(`formData[${index}][${key}]`, value);
                    }
                });
            });
            // Append formSettingData to formDataObj
            Object.entries(apiData.formSettingData).forEach(([key, value]) => {
                if (typeof value === "object" && value !== null) {
                    console.log("if");
                    Object.entries(value).forEach(([subKey, subValue]) => {
                        formDataObj.append(
                            `formSettingData[${key}][${subKey}]`,
                            subValue,
                        );
                    });
                } else {
                    formDataObj.append(`formSettingData[${key}]`, value);
                }
            });

            // Prepare Form DataObj
            // Call Api
            return formDataObj;
        },

        validateTitle(formList) {
            return (
                formList[0].formInfo.sectionTitle &&
                formList[0].formInfo.sectionTitle.trim() !== ""
            );
        },

        validateQuestion(item) {
            return item.questionValue && item.questionValue.trim() !== "";
        },

        validateAnswers(data) {
            return data.some(
                (option) => option.value && option.value.trim() !== "",
            );
        },

        validateCorrectAnswer(answers) {
            return answers.some((answer) => answer.isCorrect);
        },

        prepareFormData(id) {
            let hasError = [];
            const formData = this.formList.map((item) => {
                item.questionError = null;
                item.titleError = null;
                item.answerError = null;

                if (!this.validateTitle(this.formList)) {
                    item.titleError = "Title is empty";
                    hasError.push("titleError");
                }

                if (!this.validateQuestion(item)) {
                    item.questionError =
                        "Either questionValue or questionImg must be provided.";
                    hasError.push("questionError");
                }

                const answers = item.data.map((option) => {
                    let answerError = null;

                    if (!this.validateAnswers([option])) {
                        answerError =
                            " value must be provided for correct answers.";
                        option.answerError = answerError;
                        hasError.push("answerError");
                    } else {
                        option.answerError = null;
                    }

                    return {
                        value: option.value,
                        isCorrect: option.isCorrect,
                        img: option.img,
                    };
                });

                if (!this.validateCorrectAnswer(answers)) {
                    item.answerError =
                        "At least one answer must be marked as correct.";
                    hasError.push("isCorrect");
                }

                return {
                    questionType: item.selectedValue,
                    questionValue: item.questionValue,
                    questionImg: item.questionImg,
                    questionMark: item.questionMark,
                    answers,
                };
            });

            // setting Validation
            if (this.formSetting.specificTime) {
                if (
                    !this.formSetting.examTime.date ||
                    !this.formSetting.examTime.from ||
                    !this.formSetting.examTime.to
                ) {
                    hasError.push("SettingError");
                } else {
                    // Extract date parts from the selected date
                    const selectedDateParts =
                        this.formSetting.examTime.date.split("-");
                    const selectedYear = parseInt(selectedDateParts[0]);
                    const selectedMonth = parseInt(selectedDateParts[1]);
                    const selectedDay = parseInt(selectedDateParts[2]);

                    // Create a Date object for the selected date
                    const selectedDate = new Date(
                        selectedYear,
                        selectedMonth - 1,
                        selectedDay,
                    ); // Subtract 1 because getMonth() expects zero-based month index

                    // Get the current date
                    const currentDate = new Date();

                    // Compare the selected date with the current date
                    if (selectedDate < currentDate) {
                        hasError.push("dateTimeRangeError");
                    }

                    // Extract time parts from the from and to times
                    const fromParts = this.formSetting.examTime.from.split(":");
                    const toParts = this.formSetting.examTime.to.split(":");

                    // Create Date objects for from and to times
                    const fromTime = new Date(
                        selectedYear,
                        selectedMonth - 1,
                        selectedDay,
                        parseInt(fromParts[0]),
                        parseInt(fromParts[1]),
                    );
                    const toTime = new Date(
                        selectedYear,
                        selectedMonth - 1,
                        selectedDay,
                        parseInt(toParts[0]),
                        parseInt(toParts[1]),
                    );

                    // Compare from time with to time
                    if (fromTime >= toTime) {
                        hasError.push("fromToError");
                    }
                }
            }
            if (this.formSetting.password) {
                if (!this.formSetting.passwordValue) {
                    hasError.push("passwordError");
                }
            }

            const formSettingData = {
                questionsMark: this.totalPoints,
                sectionTitle: this.formList[0].formInfo.sectionTitle,
                sectionDescription:
                    this.formList[0].formInfo.sectionDescription,
                formImg: null,
                email: this.formSetting.username,
                phone: this.formSetting.phone,
                password: this.formSetting.password,
                passwordValue: this.formSetting.passwordValue,
                userQuestionCount: this.formSetting.userQuestionCount,
                isOnce: this.formSetting.isOnce,
                anyTime: this.formSetting.anyTime,
                duration: this.formSetting.duration,
                specificTime: this.formSetting.specificTime,
                examTime: {
                    date: this.formSetting.examTime.date,
                    from: this.formSetting.examTime.from,
                    to: this.formSetting.examTime.to,
                    duration: this.formSetting.examTime.duration,
                    durationSwitch: this.formSetting.examTime.durationSwitch,
                },
            };

            const apiData = {
                formData,
                formSettingData,
            };

            if (hasError.length > 0) {
                for (let index = 0; index < hasError.length; index++) {
                    const element = hasError[index];
                    if (element == "SettingError") {
                        toast.error("Please Check Your date & Time Setting", {
                            autoClose: 2000,
                            position: "top-left",
                        });
                        break;
                    } else if (element == "dateTimeRangeError") {
                        toast.error(
                            "Please Make sure that the date is less than the current date ",
                            { autoClose: 2000, position: "top-left" },
                        );
                        break;
                    } else if (element == "fromToError") {
                        toast.error("Please Check Time Range", {
                            autoClose: 2000,
                            position: "top-left",
                        });
                        break;
                    } else if (element == "passwordError") {
                        toast.error(
                            "Please Enter Password  Or Turn Of Password Switch ",
                            { autoClose: 2000, position: "top-left" },
                        );
                        break;
                    } else {
                        toast.error("Please Check Error Icons Inside Form ", {
                            autoClose: 2000,
                            position: "top-left",
                        });
                        break;
                    }
                }
                this.generatedFormID = null;
                return;
            }
            this.prepareFormDataObj(apiData,id);
        },

        prepareFormDataWithReturn() {
            let hasError = [];
            // to do => handle formlist and form data (the url attribute was removed from the form data and we need it to handle not sending the image file :))
            console.log('form list before processing ! =>', this.formList)
            const formData = this.formList.map((item) => {
                item.questionError = null;
                item.titleError = null;
                item.answerError = null;

                if (!this.validateTitle(this.formList)) {
                    item.titleError = "Title is empty";
                    hasError.push("titleError");
                }

                if (!this.validateQuestion(item)) {
                    item.questionError =
                        "Either questionValue or questionImg must be provided.";
                    hasError.push("questionError");
                }

                const answers = item.data.map((option) => {
                    let answerError = null;

                    if (!this.validateAnswers([option])) {
                        answerError =
                            " value must be provided for correct answers.";
                        option.answerError = answerError;
                        hasError.push("answerError");
                    } else {
                        option.answerError = null;
                    }

                    const returnedObject = {
                        value: option.value,
                        isCorrect: option.isCorrect,
                        img: option.img,
                    }

                    // if we have the image url then don't sent null to replace the image
                    if(option.image&&!option.img){
                        delete returnedObject.img
                    }

                    return returnedObject;
                });

                if (!this.validateCorrectAnswer(answers)) {
                    item.answerError =
                        "At least one answer must be marked as correct.";
                    hasError.push("isCorrect");
                }

                const returnedObject ={
                    questionType: item.selectedValue,
                    questionValue: item.questionValue,
                    questionImg: item.questionImg,
                    questionMark: item.questionMark,
                    answers,
                }

                // if we have the image url then don't sent null to replace the image
                if(item.imageFileDataUrl&&!item.questionImg){
                    delete returnedObject.questionImg
                }

                return returnedObject;
            });

            // setting Validation
            if (this.formSetting.specificTime) {
                if (
                    !this.formSetting.examTime.date ||
                    !this.formSetting.examTime.from ||
                    !this.formSetting.examTime.to
                ) {
                    hasError.push("SettingError");
                } else {
                    // Extract date parts from the selected date
                    const selectedDateParts =
                        this.formSetting.examTime.date.split("-");
                    const selectedYear = parseInt(selectedDateParts[0]);
                    const selectedMonth = parseInt(selectedDateParts[1]);
                    const selectedDay = parseInt(selectedDateParts[2]);

                    // Create a Date object for the selected date
                    const selectedDate = new Date(
                        selectedYear,
                        selectedMonth - 1,
                        selectedDay,
                    ); // Subtract 1 because getMonth() expects zero-based month index

                    // Get the current date
                    const currentDate = new Date();

                    // Compare the selected date with the current date
                    if (selectedDate < currentDate) {
                        hasError.push("dateTimeRangeError");
                    }

                    // Extract time parts from the from and to times
                    const fromParts = this.formSetting.examTime.from.split(":");
                    const toParts = this.formSetting.examTime.to.split(":");

                    // Create Date objects for from and to times
                    const fromTime = new Date(
                        selectedYear,
                        selectedMonth - 1,
                        selectedDay,
                        parseInt(fromParts[0]),
                        parseInt(fromParts[1]),
                    );
                    const toTime = new Date(
                        selectedYear,
                        selectedMonth - 1,
                        selectedDay,
                        parseInt(toParts[0]),
                        parseInt(toParts[1]),
                    );

                    // Compare from time with to time
                    if (fromTime >= toTime) {
                        hasError.push("fromToError");
                    }
                }
            }
            if (this.formSetting.password) {
                if (!this.formSetting.passwordValue) {
                    hasError.push("passwordError");
                }
            }

            const formSettingData = {
                questionsMark: this.totalPoints,
                sectionTitle: this.formList[0].formInfo.sectionTitle,
                sectionDescription:
                    this.formList[0].formInfo.sectionDescription,
                formImg: null,
                email: this.formSetting.username,
                phone: this.formSetting.phone,
                password: this.formSetting.password,
                passwordValue: this.formSetting.passwordValue,
                userQuestionCount: this.formSetting.userQuestionCount,
                isOnce: this.formSetting.isOnce,
                anyTime: this.formSetting.anyTime,
                duration: this.formSetting.duration,
                specificTime: this.formSetting.specificTime,
                examTime: {
                    date: this.formSetting.examTime.date,
                    from: this.formSetting.examTime.from,
                    to: this.formSetting.examTime.to,
                    duration: this.formSetting.examTime.duration,
                    durationSwitch: this.formSetting.examTime.durationSwitch,
                },
            };
            console.log('api data sent to next stage =>',formData)
            const apiData = {
                formData,
                formSettingData,
            };

            if (hasError.length > 0) {
                for (let index = 0; index < hasError.length; index++) {
                    const element = hasError[index];
                    if (element == "SettingError") {
                        toast.error("Please Check Your date & Time Setting", {
                            autoClose: 2000,
                            position: "top-left",
                        });
                        break;
                    } else if (element == "dateTimeRangeError") {
                        toast.error(
                            "Please Make sure that the date is less than the current date ",
                            { autoClose: 2000, position: "top-left" },
                        );
                        break;
                    } else if (element == "fromToError") {
                        toast.error("Please Check Time Range", {
                            autoClose: 2000,
                            position: "top-left",
                        });
                        break;
                    } else if (element == "passwordError") {
                        toast.error(
                            "Please Enter Password  Or Turn Of Password Switch ",
                            { autoClose: 2000, position: "top-left" },
                        );
                        break;
                    } else {
                        toast.error("Please Check Error Icons Inside Form ", {
                            autoClose: 2000,
                            position: "top-left",
                        });
                        break;
                    }
                }
                this.generatedFormID = null;
                return;
            }
            return this.prepareFormDataObjWithReturn(apiData);
        },

        // call apis

        // handle Create Quiz API
        handleCreateQuiz(formDataObj,id) {
            formDataObj.append("teacher_id", id?id:localStorage.getItem("id"));
            this.generatedFormID = null;
            // console.log(this.token , '"gggg"');
            fetch(`${this.baseUrl}/api/${id?'admin/generateQuiz':'googleformsmodules'}`, {
                method: "POST",
                body: formDataObj,
                headers: {
                    Authorization: "Bearer " + this.token,
                },
            })
                .then((response) => {
                    if (response.status === 401) {
                        useAuthStore().handleUnauthorized();
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data.success == true) {
                        toast.success("Form has been submitted successfully", {
                            autoClose: 2000,
                            position: "top-left",
                        });
                        this.generatedFormID = data.generated_id;
                        console.log(data);
                        //   localStorage.setItem("generatedId", JSON.stringify(data.generated_id));
                    } else {
                        toast.error("Please Check Errors Icons Inside Form", {
                            autoClose: 2000,
                            position: "top-left",
                        });
                        //   this.generatedFormID = null;
                    }
                })
                .catch((error) => {
                    toast.error("Something Wrong", {
                        autoClose: 2000,
                        position: "top-left",
                    });
                });
        },

        // handle send user info  for get token api

        handleSendUserInfo(token, generated_id) {
            this.quizToken = token;
            this.generatedFormID = generated_id;
        },

        handleQuizAnswer(answers,formToken) {
            this.quizToken =
                this.quizToken == null
                    ? localStorage.getItem("quizToken")
                    : this.quizToken;
            const formData = {
                token: this.quizToken,
                answers: answers,
            };
            fetch(
                `${this.baseUrl}/api/googleformsmodules/submitformAnswers/${formToken}`,
                {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        token: this.quizToken,
                        answers: answers,
                    }),
                },
            )
                .then((response) => {
                    if (response.status === 401) {
                        authStore.blockQuizAccess(formToken);
                    }
                    return response.json();
                })
                .then((data) => {
                    console.log(data);
                    if (data.success) {
                        this.degree = data.Degree;
                        localStorage.setItem("degree", data.Degree);
                        this.$router.replace({ path: "/result" });
                        localStorage.removeItem("quizData");
                        localStorage.removeItem("token");
                        localStorage.removeItem("quizId");
                    } else {
                        console.log(data);
                        this.$router.replace({ path: "/result" });
                        localStorage.setItem("degree", " No Data Found!");
                        localStorage.removeItem("quizData");
                        localStorage.removeItem("token");
                        localStorage.removeItem("quizId");
                    }
                })
                .catch((error) => {
                    console.error("Error loading data:", error);
                });
        },
    },
});
