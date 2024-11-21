function lightenColor(hex, percent) {
    if (Array.isArray(hex)) {
        // Si `hex` es un array de colores, aplicamos lightenColor a cada color
        return hex.map(function (color) {
            return lightenColor(color, percent);
        });
    }

    // Caso para un solo color, como en la versión anterior
    hex = hex.replace('#', '');
    if (hex.length === 3) {
        hex = hex.split('').map(function (char) {
            return char + char;
        }).join('');
    }

    var r = parseInt(hex.substring(0, 2), 16);
    var g = parseInt(hex.substring(2, 4), 16);
    var b = parseInt(hex.substring(4, 6), 16);

    r = Math.min(255, Math.round(r + (255 - r) * percent));
    g = Math.min(255, Math.round(g + (255 - g) * percent));
    b = Math.min(255, Math.round(b + (255 - b) * percent));

    var newHex = '#' + r.toString(16).padStart(2, '0') + g.toString(16).padStart(2, '0') + b.toString(16).padStart(2, '0');

    return newHex;
}