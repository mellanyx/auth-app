export const toasts = {
    showToast: (msg, idToast, classes) => {
        let myToastEl = document.getElementById(idToast);

        for (let className of classes) {
            myToastEl.classList.add(className);
        }

        myToastEl.querySelector('.toast-body').innerHTML = msg;

        let myToast = bs.Toast.getInstance(myToastEl);

        myToast.show();
    }
}
