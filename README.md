<img src="pix/logo.png" align="right" />

AI Course Designer plugin for Moodle
====================================
![PHP](https://img.shields.io/badge/PHP-v7.2%2F%20v7.3%2F%20v7.4%2F%20v8.0%2F%20v8.1-blue.svg)
![Moodle](https://img.shields.io/badge/Moodle-v3.9%20to%20v4.2-orange.svg)
[![GitHub Issues](https://img.shields.io/github/issues/michael-milette/moodle-local_aiid.svg)](https://github.com/michael-milette/moodle-local_aiid/issues)
[![Contributions welcome](https://img.shields.io/badge/contributions-welcome-green.svg)](#contributing)
[![License](https://img.shields.io/badge/License-GPL%20v3-blue.svg)](#license)

# Table of Contents

- [AI Course Designer plugin for Moodle](#ai-course-designer-plugin-for-moodle)
- [Table of Contents](#table-of-contents)
- [Basic Overview](#basic-overview)
- [Requirements](#requirements)
- [Download AI Course Designer for Moodle](#download-ai-course-designer-for-moodle)
- [Installation](#installation)
- [Usage](#usage)
- [Updating](#updating)
- [Uninstallation](#uninstallation)
- [Limitations](#limitations)
- [Language Support](#language-support)
- [Troubleshooting](#troubleshooting)
- [FAQ](#faq)
- [Contributing](#contributing)
- [Motivation for this plugin](#motivation-for-this-plugin)
- [Further Information](#further-information)
- [License](#license)

# Basic Overview

AI Course Designer for Moodle enables content creators to easily generate and create courses in Moodle using GPT artificial intelligence.

[(Back to top)](#table-of-contents)

# Requirements

This plugin requires Moodle 3.9+ from https://moodle.org/ and an active account on openai.com. Note that some features require more recent versions of Moodle.

[(Back to top)](#table-of-contents)

# Download AI Course Designer for Moodle

The most recent ALPHA release of AI Course Designer for Moodle is NOT YET available from:
https://moodle.org/plugins/local_aiid

The most recent DEVELOPMENT release can be found at:
https://github.com/michael-milette/moodle-local_aiid

[(Back to top)](#table-of-contents)

# Installation

Install the plugin, like any other plugin, to the following folder:

    /local/aiid

See https://docs.moodle.org/en/Installing_plugins for details on installing Moodle plugins.

This plugin requries a commercial subscription via a paid or trial OpenAI account. To get started, create an OpenAI account [here](https://openai.com/api/). Once a paid account is created, all you need to do is to create an API key and add it to the plugin settings.

AI Course Designer for Moodle includes the following settings. These are available on the plugin's **Settings** page by going to:

Site administration > Plugins > Local > AI Course Designer

[(Back to top)](#table-of-contents)

# Usage

IMPORTANT: This ALPHA release has NOT been tested on many Moodle sites. Although we expect everything to work, if you find a problem, please help by reporting it in the [Bug Tracker](https://github.com/michael-milette/moodle-local_aiid/issues).

# Updating

There are no special considerations required for updating the plugin.

The first public ALPHA version has not yet been released.

For more information on releases since then, see
[CHANGELOG.md](https://github.com/michael-milette/moodle-local_aiid/blob/master/CHANGELOG.md).

[(Back to top)](#table-of-contents)

# Uninstallation

Uninstalling the plugin by going into the following:

Home > Administration > Site Administration > Plugins > Manage plugins > AI Course Designer

...and click Uninstall. You may also need to manually delete the following folder if your webserver does not have the required permissions:

    /local/aiid

# Limitations

The plugin is currently incomplete.

The plugin can only create courses in languages for which language packs are installed on the site and that which GPT supports. This plugin has not been tested for right-to-left (RTL) language support. If you want to use this plugin with an RTL language and it doesn't work as-is, feel free to prepare a pull request and submit it to the project page at:

https://github.com/michael-milette/moodle-local_aiid

# Language Support

This plugin includes support for the English language.

If you need a different language that is not yet supported, please feel free to contribute using the Moodle AMOS Translation Toolkit for Moodle at

https://lang.moodle.org/

Customizing or translating Generative prompts

You can translate or customize existing generative AI prompts in Moodle's language editor. Here is how to do it:

1. Navigate to Site Administration > Language > Language Customization.
2. Select the language you want to customize.
3. Click the **Open Language Pack for Editing** button.
4. Wait until the **Continue** button appears. This may take a little time. Please be patient.
5. In the **Show Strings of These Components** field, scroll down and select **local_aiid.php**.
6. Click the **Show Strings** button.
7. Scroll down to the strings that begin with **prompt_**.
8. Edit the prompts as needed.
9. Scroll to the bottom of the page and click the **Save changes to the language pack** button.

For more information on editing language strings in Moodle, visit https://docs.moodle.org/en/Language_customisation.

[(Back to top)](#table-of-contents)

# Troubleshooting

More helpful information can be found in the [FAQ](#faq) below.

# FAQ

IMPORTANT: Although we expect everything to work, this release has not been fully tested in every situation. If you find a problem, please help by reporting it in the [Bug Tracker](https://github.com/michael-milette/moodle-local_aiid/issues).

**Does AIID log course generation requests?**

Not yet. However it will in the future for security audit reasons.

**Are there any security considerations?**

Security has not yet been implemented. Currently, only site administrators can use the tool.

**How can I get answers to other questions?**

Got a burning question that is not covered here? If you can't find your answer, submit your question in the Moodle forums or open a new issue on Github at:

https://github.com/michael-milette/moodle-local_aiid/issues

[(Back to top)](#table-of-contents)

# Contributing

If you are interested in helping, please take a look at our [contributing](https://github.com/michael-milette/moodle-local_aiid/blob/master/CONTRIBUTING.md) guidelines for details on our code of conduct and the process for submitting pull requests to us.

**Contributors**

Michael Milette - Author and Lead Developer

Big thank you to the following contributors. (Please let me know if I forgot to include you in the list):

* [Nobody but the author yet - be the first?]

Thank you also to all the people who have requested features, tested and reported bugs.

**Pending Features**

If have specific requirements, consider contributing or hiring us to accelerate development.

[(Back to top)](#table-of-contents)

# Motivation for this plugin

The development of this plugin was motivated by our own experience in Moodle development, features requested by our clients and topics discussed in the Moodle forums. The project is sponsored and supported by TNG Consulting Inc.

[(Back to top)](#table-of-contents)

# Further Information

For further information regarding the local_aiid plugin, support or to report a bug, please visit the project page at:

https://github.com/michael-milette/moodle-local_aiid

[(Back to top)](#table-of-contents)

# License

Copyright © 2017-2023 TNG Consulting Inc. - https://www.tngconsulting.ca/

This file is part of AI Course Designer for Moodle - https://moodle.org/

AI Course Designer is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

AI Course Designer is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with AI Course Designer.  If not, see <https://www.gnu.org/licenses/>.

[(Back to top)](#table-of-contents)
