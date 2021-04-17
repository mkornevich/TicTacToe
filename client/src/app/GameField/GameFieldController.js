import GameFieldRenderer from './GameFieldRenderer'

export default class GameFieldController {

    onNewStep = function(row, col) {};

    _enabled = true;

    set enabled(en) {
        this._enabled = en;
        if (!en) {
            this.renderer.hoverCell = false;
            this.renderer.draw();
        }
    }

    set win(value) {
        this.renderer.win = value;
        this.renderer.draw();
    }

    set field(value) {
        this.renderer.field = value;
        this.renderer.draw();
    }

    constructor(canvasEl) {
        this.canvasEl = canvasEl;
        this.renderer = new GameFieldRenderer(canvasEl);
        this.renderer.draw();

        this.installMouseMoveListener();
        this.installMouseClickListener();
    }

    installMouseMoveListener() {
        let self = this;
        this.canvasEl.onmousemove = function(event) {
            let hoveredCell = self.getHoveredCell(event);
            if (self.isAllowStep(hoveredCell)) {
                self.renderer.hoverCell = hoveredCell;
                self.renderer.draw();
            } else {
                self.renderer.hoverCell = false;
                self.renderer.draw();
            }
        }
    }

    installMouseClickListener() {
        let self = this;
        this.canvasEl.onclick = function(event) {
            let hoveredCell = self.getHoveredCell(event);
            if (self.isAllowStep(hoveredCell)) {
                self.onNewStep(hoveredCell.row, hoveredCell.col)
            }
        }
    }

    getHoveredCell(event) {
        return {
            row: Math.trunc(event.offsetY / this.renderer.cellSize),
            col: Math.trunc(event.offsetX / this.renderer.cellSize)
        }
    }

    isAllowStep(cell) {
        return this.renderer.field[cell.row][cell.col] === '' && this._enabled
    }
}