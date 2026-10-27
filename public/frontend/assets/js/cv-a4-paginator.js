/**
 * Smart A4 Multi-Page Print & Live Preview Paginator
 * Automatically divides CV templates into exact A4 pages (210mm x 297mm)
 * If 1 page, shows 1 page. If 2 pages, shows 2 pages. If 3 pages, shows 3 pages.
 */
(function() {
    function runA4Pagination() {
        if (window.__a4Paginated) return;

        const candidates = document.querySelectorAll('.cv-page, .resume-page');
        if (!candidates.length) return;

        // Ensure page containers have relative positioning for footer placement
        candidates.forEach(c => {
            if (getComputedStyle(c).position === 'static') {
                c.style.position = 'relative';
            }
        });

        const A4_HEIGHT_PX = 1122; // 297mm at 96 DPI

        candidates.forEach((container) => {
            // Check if this container overflows 1 A4 page
            if (container.scrollHeight > A4_HEIGHT_PX + 15) {
                splitOverflownContainer(container, A4_HEIGHT_PX);
            }
        });

        updatePageNumbers();
        window.__a4Paginated = true;
    }

    function splitOverflownContainer(container, maxHeight) {
        const parent = container.parentNode;
        const pageClass = container.className;
        const tagName = container.tagName.toLowerCase();

        const pages = [container];
        let currentPage = container;

        // Collect direct children
        const children = Array.from(container.children).filter(el => {
            return !el.classList.contains('no-print') &&
                   !el.classList.contains('no-print-area') &&
                   !el.classList.contains('page-num') &&
                   !el.classList.contains('cv-page-num') &&
                   !el.classList.contains('page-break');
        });

        // Re-distribute children across pages
        children.forEach(child => {
            // If child is not in currentPage, append it
            if (child.parentNode !== currentPage) {
                currentPage.appendChild(child);
            }

            // Check if adding this child caused an overflow
            if (currentPage.scrollHeight > maxHeight) {
                // If this is the only element on the page, keep it here to prevent infinite loops
                if (currentPage.children.length <= 1) {
                    return;
                }

                // If this child contains sub-items (like .job-item, tr, .project-card)
                const subItems = Array.from(child.querySelectorAll('.job-item, .project-card, .edu-entry, tr, .timeline-item'));
                if (subItems.length > 1 && child.scrollHeight > 250) {
                    child.remove();
                    splitChildAcrossPages(child, subItems, pages, maxHeight, pageClass, tagName, parent);
                    currentPage = pages[pages.length - 1];
                } else {
                    // Move the entire child to a new page
                    child.remove();
                    currentPage = createNewPage(pageClass, tagName, parent, pages);
                    currentPage.appendChild(child);
                }
            }
        });
    }

    function createNewPage(pageClass, tagName, parent, pages) {
        const pageBreak = document.createElement('div');
        pageBreak.className = 'page-break auto-page-break';
        parent.appendChild(pageBreak);

        const newPage = document.createElement(tagName);
        newPage.className = pageClass;
        newPage.classList.add('auto-paginated-page');
        newPage.style.position = 'relative';
        parent.appendChild(newPage);
        pages.push(newPage);
        return newPage;
    }

    function splitChildAcrossPages(containerElement, items, pages, maxHeight, pageClass, tagName, parent) {
        let currentPage = pages[pages.length - 1];

        const header = containerElement.querySelector('.section-title, .section-header, thead');
        const containerClone = containerElement.cloneNode(false);
        if (header) {
            containerClone.appendChild(header.cloneNode(true));
        }
        currentPage.appendChild(containerClone);

        let currentSectionClone = containerClone;

        // If the section is a table, preserve tbody
        const tableBody = containerElement.querySelector('tbody');
        let currentTbody = null;
        if (tableBody) {
            currentTbody = document.createElement('tbody');
            currentSectionClone.appendChild(currentTbody);
        }

        items.forEach(item => {
            const target = currentTbody || currentSectionClone;
            target.appendChild(item);

            if (currentPage.scrollHeight > maxHeight) {
                item.remove();
                // Create a new page
                currentPage = createNewPage(pageClass, tagName, parent, pages);
                currentSectionClone = containerElement.cloneNode(false);

                if (header) {
                    const contHeader = header.cloneNode(true);
                    contHeader.innerHTML += ' <span style="font-size: 0.78em; font-weight: normal; opacity: 0.7;">(Contd.)</span>';
                    currentSectionClone.appendChild(contHeader);
                }

                if (tableBody) {
                    currentTbody = document.createElement('tbody');
                    currentSectionClone.appendChild(currentTbody);
                }

                currentPage.appendChild(currentSectionClone);
                const newTarget = currentTbody || currentSectionClone;
                newTarget.appendChild(item);
            }
        });
    }

    function updatePageNumbers() {
        const allPages = document.querySelectorAll('.cv-page, .resume-page');
        const total = allPages.length;

        allPages.forEach((page, idx) => {
            const pageNum = idx + 1;
            const existing = page.querySelectorAll('.page-num, .cv-page-num');
            existing.forEach(e => e.remove());

            const footer = document.createElement('div');
            footer.className = 'page-num cv-page-num';
            footer.style.cssText = 'position: absolute; bottom: 8px; right: 20px; font-size: 8.5px; color: #94a3b8; font-weight: 600; pointer-events: none;';
            footer.innerText = `Page ${pageNum} of ${total}`;
            page.appendChild(footer);
        });
    }

    // Attach listener
    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        setTimeout(runA4Pagination, 60);
    } else {
        window.addEventListener('DOMContentLoaded', runA4Pagination);
    }
    window.addEventListener('load', runA4Pagination);
})();
