class PaymentTimer {
    constructor(expirationTime) {
        this.expirationTime = new Date(expirationTime).getTime();
        this.timerElement = document.createElement('div');
        this.timerElement.className = 'timer';
    }

    start() {
        this.updateTimer();
        this.interval = setInterval(() => this.updateTimer(), 1000);
    }

    updateTimer() {
        const now = new Date().getTime();
        const distance = this.expirationTime - now;

        if (distance < 0) {
            clearInterval(this.interval);
            this.timerElement.innerHTML = "EXPIRED";
            return;
        }

        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        this.timerElement.innerHTML = 
            `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }
}

// Initialize timers on modal show
document.querySelectorAll('.invoice-item').forEach(item => {
    item.addEventListener('click', () => {
        const dueDate = item.dataset.dueDate;
        new PaymentTimer(dueDate).start();
    });
});
