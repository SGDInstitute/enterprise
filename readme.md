# SGD Institute Enterprise

## Badge Printing

Install brother_ql
Export the printer model `export BROTHER_QL_MODEL=QL-800`
Export the printer location `export BROTHER_QL_PRINTER=usb://{vendor}:{product}/{serial}`
    The vendor, product and serial can be found in `System Information`
    [GitHub issue with more information](https://github.com/pklaus/brother_ql/issues/110)
Run the script `pa print`
