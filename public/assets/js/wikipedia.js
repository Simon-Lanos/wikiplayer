String.prototype.capitalize = function () {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

const updateRank = score => {
    const ranks = [
        {
            'name': 'goblin',
            'min': 0,
            'max': 600,
        },
        {
            'name': 'archer',
            'min': 600,
            'max': 2000,
        },
        {
            'name': 'gardien',
            'min': 2000,
            'max': 5000,
        },
        {
            'name': 'sorcier',
            'min': 5000,
            'max': 9000,
        },
        {
            'name': 'dragon',
            'min': 9000,
            'max': 15000,
        },
        {
            'name': 'mage',
            'min': 15000,
            'max': -1,
        },
    ]


    const availableRanks = ranks.filter(rank => {
        return score >= rank.min && (score < rank.max || rank.max === -1)
    });

    if (availableRanks.length !== 1) {
        console.error('An error occured in new rank calculation');
        console.log(score, ranks, availableRanks)
        return;
    }

    const [rankToSet] = availableRanks;

    let progress = document.querySelector('#progress');
    let rankLabel = document.querySelector('#rank');
    let rankValue = document.querySelector('#rank-value');

    rankLabel.textContent = rankToSet.name.capitalize();

    const rankText = `${score} / ${rankToSet.max === -1 ? rankToSet.min : rankToSet.max }`;
    rankValue.textContent = rankText;
    progress.max = rankToSet.max;
    progress.value = score;
    progress.title = rankText;
};

const headers = new Headers();
headers.append('Content-Type', 'application/json');

const init = {
    method: 'GET',
    headers: headers
};

let username = 'Oiseau des bois'
let score = 0;
const date = '2021-06-01T00:00:00Z';

(function get(next) {
    const url = `https://fr.wikipedia.org/w/api.php?action=query&format=json&origin=*&list=logevents&letitle=Utilisateur:${username}&letype=thanks&lelimit=500&leend=${date}`
    fetch(url + (next ? '&lecontinue=' + next : ''), init)
        .then(response => {
            return response.json();
        }).then(resp => {
            score += resp.query.logevents.length * 10;
            console.log(resp);
            if (resp.continue) {
                get(resp.continue.lecontinue);
            }
            updateRank(score);
    });
})();

(function get(next) {
    const url = `https://fr.wikipedia.org/w/api.php?action=query&format=json&origin=*&list=usercontribs&ucuser=${username}&uclimit=500&ucend=${date}`
    fetch(url + (next ? '&uccontinue=' + next : ''), init)
        .then(response => {
            return response.json();
        }).then(resp => {
            score += resp.query.usercontribs.reduce((total, usercontrib) => {
                if (usercontrib.size < 100) {
                    return total + 1
                } else if (usercontrib.size < 1000) {
                    return total + 3
                } else {
                    return total + 10
                }
            }, 0);
            console.log(resp);
            if (resp.continue) {
                get(resp.continue.uccontinue);
            }
            updateRank(score);
    });
})();
