export default class GameFieldRenderer {

    field = [
        ['', '', '', '', '', '', '', '', '', ''],
        ['', '', '', '', '', '', '', '', '', ''],
        ['', '', '', '', '', '', '', '', '', ''],
        ['', '', '', '', '', '', '', '', '', ''],
        ['', '', '', '', '', '', '', '', '', ''],
        ['', '', '', '', '', '', '', '', '', ''],
        ['', '', '', '', '', '', '', '', '', ''],
        ['', '', '', '', '', '', '', '', '', ''],
        ['', '', '', '', '', '', '', '', '', ''],
        ['', '', '', '', '', '', '', '', '', ''],
    ];

    win = { // or false
        row: 0,
        col: 1,
        direction: 'right-bottom'
    };

    hoverCell = { // or false
        row: 0,
        col: 3,
    };

    constructor(canvasEl) {
        this.fieldSizeCell = 10;
        this.fieldSizePx = canvasEl.offsetWidth;
        this.ctx = canvasEl.getContext('2d');
        this.cellSize = this.fieldSizePx / this.fieldSizeCell;
    }

    draw() {
        this.clear();
        this.drawGrid();
        this.drawCrossesAndNulls();
        this.drawWin();
        this.drawHoverCell();
    }

    drawHoverCell(){
        if (this.hoverCell === false) return;
        this.ctxSet("#9c9c9c", 2);
        this.ctx.strokeRect(this.cellSize * this.hoverCell.col, this.cellSize * this.hoverCell.row, this.cellSize, this.cellSize);
    }

    clear() {
        this.ctx.clearRect(0, 0, this.fieldSizePx, this.fieldSizePx);
    }

    drawWin() {
        if (this.win === false) return;

        let startX = this.win.col * this.cellSize + this.cellSize / 2;
        let startY = this.win.row * this.cellSize + this.cellSize / 2;

        let endX = startX + (this.win.direction.indexOf('right') === -1 ? 0 : this.cellSize * 4);
        let endY = startY + (this.win.direction.indexOf('bottom') === -1 ? 0 : this.cellSize * 4);

        this.ctxSet('#515151', 2);
        this.ctx.beginPath();
        this.ctx.moveTo(startX, startY);
        this.ctx.lineTo(endX, endY);
        this.ctx.stroke();
    }

    drawCrossesAndNulls() {
        for (let row = 0; row < this.fieldSizeCell; row++) {
            for (let col = 0; col < this.fieldSizeCell; col++) {
                if (this.field[row][col] === 'x') {
                    this.drawCross(row, col);
                } else if (this.field[row][col] === 'o') {
                    this.drawNull(row, col);
                }
            }
        }
    }

    drawCross(row, col) {
        this.ctxSet('#007bff', 4);
        let padding = 10;

        this.ctx.beginPath();
        this.ctx.moveTo(col * this.cellSize + padding, row * this.cellSize + padding);
        this.ctx.lineTo(col * this.cellSize + this.cellSize - padding, row * this.cellSize + this.cellSize - padding);
        this.ctx.stroke();

        this.ctx.beginPath();
        this.ctx.moveTo(col * this.cellSize + this.cellSize - padding, row * this.cellSize + padding);
        this.ctx.lineTo(col * this.cellSize + padding, row * this.cellSize + this.cellSize - padding);
        this.ctx.stroke();
    }

    drawNull(row, col) {
        this.ctxSet("#dc3545", 4);
        let padding = 10;

        this.ctx.beginPath();
        this.ctx.arc(
            col * this.cellSize + (this.cellSize / 2),
            row * this.cellSize + (this.cellSize / 2),
            this.cellSize / 2 - padding,
            0,
            Math.PI * 2
        );
        this.ctx.stroke();
    }

    drawGrid() {
        this.ctxSet("#C9C9C9");
        this.ctx.lineWidth = 1;
        for(let i = 1; i < this.fieldSizeCell; i++) {
            this.ctx.beginPath();
            this.ctx.moveTo(0, this.cellSize * i);
            this.ctx.lineTo(this.fieldSizePx, this.cellSize * i);
            this.ctx.stroke();

            this.ctx.beginPath();
            this.ctx.moveTo(this.cellSize * i , 0);
            this.ctx.lineTo(this.cellSize * i, this.fieldSizePx);
            this.ctx.stroke();
        }
    }

    ctxSet(strokeStyle, lineWidth = 1, lineCap = 'round') {
        this.ctx.strokeStyle = strokeStyle;
        this.ctx.lineWidth = lineWidth;
        this.ctx.lineCap = lineCap;
    }
}