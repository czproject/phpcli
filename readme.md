PHP CLI Helper Class
--------------------

``` php
use Cz\Cli;
require __DIR__ . '/Cli.php';

Cli::log('Hello!');
Cli::error('Error!');
Cli::success('Success!');
Cli::warn('Warning!');
Cli::info('Info!');

Cli::format('Hello!!' /*text*/, TRUE /*bold*/, Cli::C_YELLOW /*color*/);
```

Author: Jan Pecha (http://janpecha.iunas.cz/)
<br>License: [New BSD License](license.md)

