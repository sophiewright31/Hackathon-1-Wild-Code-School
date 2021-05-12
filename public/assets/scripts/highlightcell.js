var highlightModal = (document.getElementById('mapcontent').dataset.highlightcell);
highlightcells = JSON.parse(highlightModal);
console.log(highlightcells)
for (let i=0; i<highlightcells.length; i++) {
    console.log(highlightcells[i])
    celltohighlight = document.getElementById('cell' + highlightcells[i]);
    celltohighlight.classList.add('highlighted-cell');
}
