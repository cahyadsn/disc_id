/**
 * DISC Personality Test Chart
 * Draws an SVG line chart for DISC analysis results.
 * Zero dependencies (Vanilla JS).
 */
function drawDiscChart(elementId, data, options) {
  const container = document.getElementById(elementId);
  if (!container) return;

  // Clear container
  container.innerHTML = '';

  const width = options.width || 400;
  const height = options.height || 300;
  const padding = { top: 35, right: 20, bottom: 40, left: 30 };

  const yMin = options.ymin !== undefined ? options.ymin : -8;
  const yMax = options.ymax !== undefined ? options.ymax : 8;

  // Beautiful modern DISC colors
  // blue (MOST), red (LEAST), green (CHANGE)
  const colors = options.colors || ['#38bdf8', '#f43f5e', '#a855f7'];

  // Create SVG element
  const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
  svg.setAttribute('width', '100%');
  svg.setAttribute('height', '100%');
  svg.setAttribute('viewBox', `0 0 ${width} ${height}`);
  svg.style.fontFamily = 'Outfit, sans-serif';

  // Helper functions for mapping coordinates
  const getX = (index) => {
    return padding.left + (index * (width - padding.left - padding.right) / (data.length - 1));
  };

  const getY = (val) => {
    const ratio = (val - yMin) / (yMax - yMin);
    return height - padding.bottom - (ratio * (height - padding.top - padding.bottom));
  };

  // Draw grid lines and Y-axis labels
  const yTicks = 9; // -8, -6, -4, -2, 0, 2, 4, 6, 8
  for (let i = 0; i < yTicks; i++) {
    const val = yMin + i * (yMax - yMin) / (yTicks - 1);
    const y = getY(val);

    // Grid line
    const gridLine = document.createElementNS('http://www.w3.org/2000/svg', 'line');
    gridLine.setAttribute('x1', padding.left);
    gridLine.setAttribute('y1', y);
    gridLine.setAttribute('x2', width - padding.right);
    gridLine.setAttribute('y2', y);
    gridLine.setAttribute('stroke', val === 0 ? 'rgba(255, 255, 255, 0.3)' : 'rgba(255, 255, 255, 0.08)');
    gridLine.setAttribute('stroke-width', val === 0 ? '1.5' : '1');
    if (val !== 0) {
      gridLine.setAttribute('stroke-dasharray', '3,3');
    }
    svg.appendChild(gridLine);

    // Label
    const text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
    text.setAttribute('x', padding.left - 8);
    text.setAttribute('y', y + 4);
    text.setAttribute('text-anchor', 'end');
    text.setAttribute('font-size', '10');
    text.setAttribute('fill', '#94a3b8');
    text.textContent = val;
    svg.appendChild(text);
  }

  // Draw X axis labels and vertical grid lines
  data.forEach((d, idx) => {
    const x = getX(idx);

    // Vertical line
    const gridLine = document.createElementNS('http://www.w3.org/2000/svg', 'line');
    gridLine.setAttribute('x1', x);
    gridLine.setAttribute('y1', padding.top);
    gridLine.setAttribute('x2', x);
    gridLine.setAttribute('y2', height - padding.bottom);
    gridLine.setAttribute('stroke', 'rgba(255, 255, 255, 0.08)');
    gridLine.setAttribute('stroke-dasharray', '3,3');
    svg.appendChild(gridLine);

    // Label
    const text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
    text.setAttribute('x', x);
    text.setAttribute('y', height - padding.bottom + 20);
    text.setAttribute('text-anchor', 'middle');
    text.setAttribute('font-size', '12');
    text.setAttribute('font-weight', 'bold');
    text.setAttribute('fill', '#f8fafc');
    text.textContent = d.y;
    svg.appendChild(text);
  });

  // Draw lines
  const keys = options.ykeys || ['a', 'b', 'c'];
  const labels = options.labels || [];

  keys.forEach((key, keyIdx) => {
    let pathD = '';
    data.forEach((d, idx) => {
      const x = getX(idx);
      const y = getY(d[key]);
      if (idx === 0) {
        pathD += `M ${x} ${y}`;
      } else {
        pathD += ` L ${x} ${y}`;
      }
    });

    // Path element
    const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    path.setAttribute('d', pathD);
    path.setAttribute('fill', 'none');
    path.setAttribute('stroke', colors[keyIdx]);
    path.setAttribute('stroke-width', '2.5');
    svg.appendChild(path);

    // Points on the path
    data.forEach((d, idx) => {
      const x = getX(idx);
      const y = getY(d[key]);

      const circle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
      circle.setAttribute('cx', x);
      circle.setAttribute('cy', y);
      circle.setAttribute('r', '4');
      circle.setAttribute('fill', colors[keyIdx]);
      circle.setAttribute('stroke', '#ffffff');
      circle.setAttribute('stroke-width', '1.5');

      // Simple hover tooltip for points
      const title = document.createElementNS('http://www.w3.org/2000/svg', 'title');
      title.textContent = `${labels[keyIdx] || key}: ${d[key]}`;
      circle.appendChild(title);

      svg.appendChild(circle);
    });
  });

  // Render legend at the top
  const legendGroup = document.createElementNS('http://www.w3.org/2000/svg', 'g');
  legendGroup.setAttribute('transform', `translate(${padding.left}, 15)`);
  
  let currentX = 0;
  labels.forEach((label, idx) => {
    const g = document.createElementNS('http://www.w3.org/2000/svg', 'g');
    g.setAttribute('transform', `translate(${currentX}, 0)`);

    const rect = document.createElementNS('http://www.w3.org/2000/svg', 'rect');
    rect.setAttribute('width', '10');
    rect.setAttribute('height', '10');
    rect.setAttribute('rx', '2');
    rect.setAttribute('fill', colors[idx]);
    g.appendChild(rect);

    const text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
    text.setAttribute('x', '15');
    text.setAttribute('y', '9');
    text.setAttribute('font-size', '9');
    text.setAttribute('fill', '#94a3b8');
    
    // Display shortened versions of labels: 'MOST', 'LEAST', 'CHANGE'
    const shortLabel = label.split(' ')[0];
    text.textContent = shortLabel;
    
    const title = document.createElementNS('http://www.w3.org/2000/svg', 'title');
    title.textContent = label;
    text.appendChild(title);

    g.appendChild(text);
    legendGroup.appendChild(g);

    currentX += 80;
  });
  svg.appendChild(legendGroup);

  container.appendChild(svg);
}
