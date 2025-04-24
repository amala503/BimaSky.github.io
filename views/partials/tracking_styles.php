<style>
    .tracking-card {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .tracking-step {
        position: relative;
        padding: 20px;
        margin-bottom: 15px;
        border-left: 3px solid #e9ecef;
    }

    .tracking-step:last-child {
        margin-bottom: 0;
    }

    .tracking-step.active {
        border-left: 3px solid #0d6efd;
    }

    .tracking-step.completed {
        border-left: 3px solid #198754;
    }

    .step-icon {
        position: absolute;
        left: -15px;
        background: white;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #e9ecef;
    }

    .tracking-step.active .step-icon {
        border-color: #0d6efd;
        color: #0d6efd;
    }

    .tracking-step.completed .step-icon {
        border-color: #198754;
        color: #198754;
    }
</style>