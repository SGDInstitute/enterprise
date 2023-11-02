# SGD Institute Enterprise

## Badge Printing

1. Install [brother_ql](https://github.com/pklaus/brother_ql)

```
pip3 install --upgrade brother_ql
```

2. Export the printer model

```
export BROTHER_QL_MODEL=QL-800
```

3. Export the printer location

```
export BROTHER_QL_PRINTER=usb://{vendor}:{product}/{serial}
```

The vendor, product and serial can be found in `System Information` [GitHub issue with more information](https://github.com/pklaus/brother_ql/issues/110)

4. Run the print badges command

```
php artisan app:print-badges
```

Make sure to have Raleway and Lato fonts installed locally
