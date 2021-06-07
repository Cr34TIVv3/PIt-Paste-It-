const ModalWindow = {
    init() {
        document.getElementsByClassName("modal__close").addEventListener("click", e => {
            this.closeModal(e.target);
        });
 
    },

    getHtmlTemplate(modalOptions) {
        return `
            <div class="modal__overlay">
                <div class="modal__window">
                    <div class="modal__titlebar">
                        <span class="modal__title">${modalOptions.title}</span>
                        <button id="modal__close">close</button>
                    </div>
                    <div class="modal__content">
                        ${modalOptions.content}
                    </div>
                </div>
            </div>
        `;
    },

    openModal(modalOptions = {}) {
        modalOptions = Object.assign({
            title: 'No members found',
            content: 'This past has no members'
        }, modalOptions);

        const modalTemplate = this.getHtmlTemplate(modalOptions);
        document.body.insertAdjacentHTML("afterbegin", modalTemplate);
    },

    closeModal(closeButton) {
        const modalOverlay = closeButton.parentElement.parentElement.parentElement;
        document.body.removeChild(modalOverlay);
    }
};


// document.getElementById("seeOtherMembers").addEventListener("click", () => {
//     ModalWindow.openModal({title: 'salut', content: "dane"});
//     document.getElementById("modal__close").addEventListener("click", e => ModalWindow.closeModal(e.target));
// });



















