let text = document.getElementById('myText').innerHTML;
      const copyContent = async () => {
        try {
          await navigator.clipboard.writeText(text);
          console.log('Content copied to clipboard');
          alert('Content copied to clipboard');
        } catch (err) {
          console.error('Failed to copy: ', err);
        }
      }

      function downloadimage() {
            /*var container = document.getElementById("image-wrap");*/ /*specific element on page*/
            var container = document.getElementById("qrcode"); /* full page */
            html2canvas(container, { allowTaint: true }).then(function (canvas) {

            // let text = document.getElementById('qrname').innerHTML;

            var link = document.createElement("a");
            document.body.appendChild(link);
            link.download = "QR Profile Digital";
            link.href = canvas.toDataURL();
            link.target = '_blank';
            link.click();
        });
    }
    
    function downloadimage2() {
            /*var container = document.getElementById("image-wrap");*/ /*specific element on page*/
            var container = document.getElementById("qrcode2"); /* full page */
            html2canvas(container, { allowTaint: true }).then(function (canvas) {

            // let text = document.getElementById('qrname').innerHTML;

            var link = document.createElement("a");
            document.body.appendChild(link);
            link.download = "QR Profile Digital";
            link.href = canvas.toDataURL();
            link.target = '_blank';
            link.click();
        });
    }