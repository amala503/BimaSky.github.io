function printInvoice(orderData) {
    // Open invoice in new window
    const printWindow = window.open('laporan/invoice.html', '_blank');
    
    // Wait for window to load
    printWindow.onload = function() {
        // Get the document of the new window
        const doc = printWindow.document;
        
        // Update invoice data
        doc.querySelector('.info-value').textContent = orderData.invoiceNumber || '010.010-24.37238201';
        
        // Update buyer info
        const buyerInfo = doc.querySelectorAll('.section')[2].querySelectorAll('.info-value');
        buyerInfo[0].textContent = orderData.buyerName || 'PT ELANG PERDANA TYPE INDUSTRY';
        buyerInfo[1].textContent = orderData.buyerAddress || 'JL. MERPATI Blok - No - RT.123 RW.456';
        buyerInfo[2].textContent = orderData.buyerNPWP || '016386112436000';
        buyerInfo[3].textContent = orderData.buyerNITU || '001638611243600000000000';
        
        // Update product details
        const gridCells = doc.querySelectorAll('.grid-cell');
        gridCells[1].textContent = orderData.productName || 'Layanan Satelit Business Service';
        gridCells[2].textContent = new Intl.NumberFormat('id-ID').format(orderData.price || 2725225) + ',00';
        
        // Update footer
        const footer = doc.querySelector('.footer');
        const qrCode = footer.querySelector('.qr-code');
        qrCode.style.backgroundImage = `url(${orderData.qrCode})`;
        
        const footerText = footer.querySelectorAll('div > div');
        footerText[1].textContent = orderData.orderNumber || 'SBS-0099-123_PT. RAJAWALI PRIMA MANUFACTURING';
        footerText[2].textContent = orderData.location + ', ' + new Date(orderData.date).toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });
        footerText[3].textContent = orderData.signerName || 'Rina Kartika Sari';
        
        // Print the document
        setTimeout(() => {
            printWindow.print();
            // Close the window after printing (optional)
            printWindow.onafterprint = function() {
                printWindow.close();
            };
        }, 1000);
    };
}