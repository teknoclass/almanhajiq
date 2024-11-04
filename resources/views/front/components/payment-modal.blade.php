<div id="payment-modal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <h4>Select Payment Method</h4>
        <button class="payment-option" data-method="zaincash">
            <img src="images/zaincash-logo.png" alt="Zain Cash" class="payment-logo">
        </button>
        <button class="payment-option" data-method="qi">
            <img src="images/qi-logo.png" alt="Qi" class="payment-logo">
        </button>
        <button id="close-modal" class="close-btn">Close</button>
    </div>
</div>

<style>
    .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.modal-content {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    width: 300px;
}

.payment-logo {
    width: 100px;
    height: auto;
    margin: 10px;
    cursor: pointer;
}

.close-btn {
    background: #ccc;
    border: none;
    padding: 8px 16px;
    cursor: pointer;
    margin-top: 10px;
}

</style>