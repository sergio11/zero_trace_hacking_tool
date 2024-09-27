# 🌐 **ZeroTrace**: The Ultimate Ethical Hacking & Search Engine Dorking Tool 🔍🚀

Welcome to **ZeroTrace**, your go-to tool for ethical hacking and advanced search engine dorking! ⚡

ZeroTrace is an innovative tool designed for **cybersecurity professionals** and **ethical hackers** 🛡️ to identify potential **attack vectors** 🌍 across the vast expanse of the **World Wide Web**. Whether you're performing reconnaissance on a target or conducting security research, ZeroTrace helps you uncover hidden and sensitive information 🔓 that may be exposed due to **misconfigurations** or **poor security practices**.

🔒 **Disclaimer**: This tool is designed for educational and research purposes. Misuse of this tool could result in violation of laws and regulations. Please use responsibly.

## 🔍 **What is ZeroTrace?**

ZeroTrace helps **ethical hackers** and **security researchers** streamline the process of identifying sensitive information online. By generating precise and powerful Google Dorks, it automates reconnaissance activities, providing quick access to potential vulnerabilities and misconfigurations in systems exposed on the internet.

### With ZeroTrace, you can:
- 🔑 **Transform your search queries** into **optimized Google Dorks** using **AI-powered LLMs**.
- 📊 **Generate reports** with search results for documentation and analysis.
- 📂 **Download sensitive files** that may contain exposed data (e.g., `.pdf`, `.docx`, `.txt`, etc.).
- 🌐 Identify **potential attack vectors** by scanning for misconfigurations or leaked data online.

## ⚡ **Key Features**

- **AI-Powered Dork Generation** 🤖: Leverages **LLMs like Llama3** through **Groq** to generate precise Google Dorks based on user descriptions.
  
- **Automated Search Queries** 🔍: Perform advanced search queries using **Google Custom Search** to retrieve relevant results.

- **File Downloading** 💾: Automatically download files (e.g., `.pdf`, `.docx`, `.txt`) that expose sensitive information, streamlining your reconnaissance process.

- **Detailed Reports** 📝: Export search results in **HTML** and **JSON** formats for documentation and further analysis.

- **Customizable Filters** 🔧: Set specific search filters, such as file types or languages, to narrow down results and focus on the most relevant data.

## 🚀 **How It Works**

1. **Configure API Keys** 🔐: Set up your **Google API Key** and **Custom Search Engine ID**.
2. **Enter a Query**: Provide a search description or Google Dork directly.
3. **AI-Assisted Dork Generation**: ZeroTrace uses **LLMs** to generate Google Dorks based on user input.
4. **Retrieve Results**: Perform advanced searches and collect relevant information from the web.
5. **Download Files**: Automatically download files containing sensitive information.
6. **Export Reports**: Save your results in **HTML** or **JSON** formats for further analysis.

## 🧑‍💻 **Installation**

1. Clone the repository.
2. Install the required dependencies.
3. Set up your environment variables.
4. Run the tool.

## 📂 **Output Formats**

ZeroTrace allows you to export search results in multiple formats:
- **HTML Report** 📝: Nicely formatted, easy-to-read report.
- **JSON Export** 🗂️: Structured data format for further processing or analysis.

## 🤖 **AI Integration**

ZeroTrace uses **Generative AI** via **open-source models** like **Llama3** to generate high-quality, optimized Google Dorks based on natural language input. This feature allows you to easily convert descriptions into actionable Google Dorks, speeding up the reconnaissance process.

## 🎯 Usage Examples

Here are some examples of how to use **ZeroTrace** from the command line:

* Basic Google Dork Search:

Run a Google dork search to find SQL files related to MySQL dumps:

```python
python zerotrace_cli.py -d "filetype:sql \"MySQL dump\" (pass|password|passwd|pwd)" --pages 2 --json results.json --html report.html
```
This command searches for SQL files and exports the results in both JSON and HTML formats.

* AI-Generated Dork Query:

Automatically generate a Google Dork based on a description and retrieve results:

```python
python zerotrace_cli.py -q "Find text files that contain usernames and passwords." --start-page 1 --pages 3 --json output.json --html output.html
```

This command generates a dork based on the input description and retrieves results from the first three pages.

* Download Specific File Types:

Search for and download only PDF and DOC files:
```python
python zerotrace_cli.py -d "filetype:pdf OR filetype:doc \"confidential\"" --download-file-extensions "pdf,doc" --download-folder "my_downloads" --json results.json --html report.html
```
This command searches for both PDF and DOC files containing the term "confidential" and saves them in the "my_downloads" folder.

 * Download All File Types

If you want to download all file types found in the search, you can specify "all":

```python
python zerotrace_cli.py -q "site:example.com" --download-file-extensions "all" --download-folder "downloads" --pages 5 --json output.json --html report.html
```
This command retrieves results from the first five pages for the site "example.com" and downloads all file types into the "downloads" folder.

* Configure API Credentials

If you need to set up or update your API credentials, use the configure flag:

```python
python zerotrace_cli.py --configure
```
This command will guide you through configuring your Google API key and Custom Search Engine ID in the .env file.

## ⚙️ CLI Arguments

| Argument                        | Description                                                                                                                                           |
|---------------------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------|
| `-d`, `--dork`                  | Specify the Google Dork or search query.                                                                                                           |
| `-q`, `--query-dork`           | Automatically generates a Google Dork based on a description using AI.                                                                             |
| `-c`, `--configure`             | Configure or update the `.env` file with API credentials.                                                                                         |
| `--start-page`                  | The starting page number for search results (default: 1).                                                                                         |
| `--pages`                       | The number of pages to retrieve (default: 1).                                                                                                     |
| `--lang`                        | Language code for search results (default: `lang_es` for Spanish).                                                                                  |
| `--json`                        | Export results to the specified file in JSON format.                                                                                               |
| `--html`                        | Export results to the specified file in HTML format.                                                                                               |
| `--download-file-extensions`    | Specify file extensions to download, separated by commas. Use `'all'` to download all file types.                                                  |
| `--download-folder`             | Specify the folder where downloaded files will be saved. Use a custom folder name to save files in a specific directory.                          |


## 🔐 **Ethical Use**

This tool is meant for **ethical hacking** and **cybersecurity research** purposes. Ensure that you have proper authorization before using ZeroTrace for any reconnaissance activities. Unauthorized use to access or download sensitive data may be illegal in your jurisdiction.

## 🎯 **Future Improvements**

- 🛠️ **Additional AI Models**: Expanding support for more LLMs.
- ⚙️ **Custom Search Engines**: Adding support for more search engines beyond Google.
- 📊 **Advanced Reporting**: More detailed and customizable reports.

## 🤝 **Contributing**

Feel free to submit **pull requests** or **issues**. Contributions are welcome!
