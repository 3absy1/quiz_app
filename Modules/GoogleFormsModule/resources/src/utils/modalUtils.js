// a function that takes the id of the modal then close it useing vanilla js
export const closeBootstrapModalProgrammatically = (elementId) => {
    // Get a reference to the modal
    let myModal = document.getElementById(elementId);

    // Hide the modal
    myModal.classList.remove("show");
    myModal.style.display = "none";

    // Optional: Clear backdrop if needed
    const modalBackdrop = document.querySelectorAll(".modal-backdrop");
    if (modalBackdrop) {
        modalBackdrop.forEach((el) => document.body.removeChild(el));
    }
};
