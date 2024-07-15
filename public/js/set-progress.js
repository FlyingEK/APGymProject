function setProgress(element, progress) {
    const radius = element.querySelector('.fg').r.baseVal.value;
    const circumference = radius * 2 * Math.PI;
    const offset = circumference - progress / 100 * circumference;

    element.style.setProperty('--progress', progress);
    element.querySelector('.fg').style.strokeDashoffset = offset;
    element.querySelector('#progress-value').textContent = `${Math.round(progress / 100 * 30)} hours`; // Adjust this calculation based on your total value
}

function animateProgress(element, targetProgress, duration) {
    let start = null;
    const initialProgress = 0;
    const step = (timestamp) => {
        if (!start) start = timestamp;
        const progress = Math.min((timestamp - start) / duration, 1);
        const currentProgress = initialProgress + progress * (targetProgress - initialProgress);
        setProgress(element, currentProgress * 100);
        if (progress < 1) {
            window.requestAnimationFrame(step);
        }
    };
    window.requestAnimationFrame(step);
}

// Example usage
const circularProgress = document.querySelector('.circular-progress');
animateProgress(circularProgress, 0.7, 1700);