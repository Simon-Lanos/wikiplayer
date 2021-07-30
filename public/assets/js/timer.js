const timer = document.querySelector('#timer');
let time = (new Date("Aug 1, 2021 00:00:00").getTime() - new Date()) / 1000; //1837879 //seconds until dawn

setInterval(
    () => {
        time--;
        let d = Math.floor(time / (3600*24));
        let h = Math.floor(time % (3600*24) / 3600);
        let m = Math.floor(time % 3600 / 60);
        let s = Math.floor(time % 60);
        timer.textContent = `${d}j ${h}h ${m}m ${s}s`;
    },
    1000
)
