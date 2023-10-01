numberRange = document.getElementById("numberRange")
numberRange.addEventListener("input", (e) => {
    setReward()
})

let allowSpin = false

const progressBarParent = document.getElementById("progress-bar")


setReward()
function setReward() {
    let temp = (1 / (1.01 - numberRange.value / 100))
    temp = temp.toFixed(temp > 10 ? 1 : 2)
    temp > 99 && (temp = Math.round(temp))
    numberRangeDiv.innerHTML = temp + "x"
}


document.getElementById("form").addEventListener("submit", (e) => {


    if (document.getElementById("betMoney").value > money) {
        document.getElementById("money").style.color = "var(--del-color)"
        document.getElementById("betMoney").style.color = "var(--del-color)"
        e.preventDefault()
        return
    }

    if (!allowSpin) {
        progressBarParent.style.boxShadow = "0 0 15px -2px var(--del-color)"
        e.preventDefault()
        return
    }
})

const progressBar = document.getElementById("progress")

let progressAnimationTimeout

function animateProgress() {
    progressAnimationTimeout = setTimeout(() => {
        if (progressBar.value / 2 >= bet) {
            moneyDisplay.innerText = money;
            progressBar.style = "--progress-color:green";
        }

        if (progressBar.value / 2 < spin) {
            progressBar.value++
            animateProgress()
        }
        else if (!(progressBar.value / 2 >= bet) && spin != -99) {
            progressBar.style = "--progress-color:red;background-color:rgba(255, 0, 0, 0.2)"
            moneyDisplay.innerText = money;
            allowSpin = true
            progressBarParent.style.boxShadow = "none"
        }
        else { allowSpin = true; progressBarParent.style.boxShadow = "none" }

    }, progressBar.value / 5)
}

document.getElementById("betMoney").addEventListener("input", function () {
    if (this.value > money) {
        this.style.color = "var(--del-color)"
        document.getElementById("money").style.color = "var(--del-color)"
        return
    }
    this.style.color = "var(--h2-color)"
    document.getElementById("money").style.color = "var(--h2-color)"
})
