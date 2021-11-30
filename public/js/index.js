
/**
 * treeSort()-funktionin ohjeet
 * https://typeofnan.dev/an-easy-way-to-build-a-tree-with-object-references/
 * 
 */

const base_url = 'http://localhost/sandbox/micromvc/public';
let startTime;
let endTime;
let tot_back;
let tot_sql;
let tot_rows;
function init() {
    const url = base_url + '?route=api/index';
    startTime = getTime();
    const success = data => {
        console.log(data);
        tot_back = data.timer.php_tot;
        tot_sql = data.timer.sql_tot;
        tot_rows = data.timer.rows;

        const trees = treeSort(data.response);
        //console.log(trees);
        displayTrees(trees);
    };

    load(url, success);
}

function displayTrees(trees) {
    let html = '';
    //html = displayTree([trees[0]]);
    let index = 0;
    for(let tree of trees) {
        html += '<ul class="topic">'
        html += displayTree([tree]);
        html += '</ul>'
    }
    html += ''
    document.querySelector('#app').innerHTML += html;

    endTime = getTime();
    let start = '<tr><td>';
    let middle = '</td><td>';
    let end = '</td></tr>';
    document.querySelector('#tot_front').innerHTML = start+'Sivun latauksen alusta siihen kun sisältö latautunut:' + middle + ((endTime - startTime)/1000) + 's' + end;
    document.querySelector('#tot_back').innerHTML = start+'php-toteutus kokonaiskesto:' + middle + (Math.round(1000*tot_back)/1000) + 's' + end;
    document.querySelector('#tot_sql').innerHTML = start+'sql-toteutus kokonaiskesto:' + middle + (Math.round(1000*tot_sql)/1000) + 's' + end;
    document.querySelector('#tot_rows').innerHTML = start+'tietokantarivejä:' + middle + tot_rows + 'kpl' + end;
    
    blockquotes();
}

function displayTree(tree) {
    let html = '';
    for(let i = 0; i < tree.length; i++) {
        let data = tree[i];
        let children = '';
        if(data.children && data.children.length > 0) {
            children = '<ul>' + displayTree(data.children) + '</ul>';
        }
        html += '<li><div><b>' + data.id + '</b> ' + data.headline_text + '</div>' + children + '</li>';
    }
    return html;
}

function treeSort(data) {
    const output = [];
    //console.log(data);
    for(let arr of data) {
        const idMapping = arr.reduce((acc, el, i) => {
            acc[el.id] = i;
            return acc;
        }, {});
        let root;
        arr.forEach(el => {
            // Handle the root element
            if (el.parent_id === null) {
                root = el;
                return;
            }
            // Use our mapping to locate the parent element in our data array
            const parentEl = arr[idMapping[el.parent_id]];
            // Add our current el to its parent's `children` array
            parentEl.children = [...(parentEl.children || []), el];
        });
        //console.log(root);
        output.push(root);
    }
    return output;
}

function blockquotes() {
    const mlen = document.querySelectorAll('.message').length;
    for(let i = 0; i < mlen; i++) {
        const article = document.querySelectorAll('.message')[i];
        const blen = article.querySelectorAll('blockquote').length;

        for(let j = 0; j < blen; j++) {
            const child = article.querySelectorAll('blockquote')[j];
            if(j % 2 == 0) { 
                child.className += ' even';
            } else {
                child.className += ' odd';
            }
        }
    }
}

function load(url, callback, data = null) {

    data = data ? JSON.stringify(data) : data;
    const method = data ? 'POST' : 'GET';

    const headers = {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    };

    const response = response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    };

    fetch(url, {headers, method, data})
    .then(response)
    .then(callback);
}

function getTime() {
    return new Date().valueOf();
}

(()=>{
    init();
})();