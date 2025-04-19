# 🌐 **ZeroTrace**: A Personal Ethical Hacking & Search Engine Dorking Tool 🔍🚀

Welcome to **ZeroTrace**, a personal project designed to explore **ethical hacking** and **search engine dorking** techniques! ⚡

ZeroTrace is a tool built for **cybersecurity professionals** and **ethical hackers** 🛡️ to help identify **potential attack vectors** 🌍 across the web. Whether you're conducting reconnaissance or performing security research, ZeroTrace helps uncover **hidden** and **sensitive information** 🔓 that may be exposed due to **misconfigurations** or **poor security practices**.

🙏 Special thanks to [Santiago Hernández, a leading expert in Cybersecurity and Artificial Intelligence](https://www.udemy.com/user/shramos/). His course on **Cybersecurity and Ethical Hacking** on Udemy was an essential part of the learning process and contributed greatly to the development of this tool. The insights I gained through this course were key to shaping this project.

## 🔍 **What is ZeroTrace?**

**ZeroTrace** simplifies the process of finding sensitive information online, helping **ethical hackers** and **security researchers** conduct **reconnaissance** and identify vulnerabilities more efficiently. Using **AI-powered algorithms**, the tool optimizes **Google Dorks**, automating the search for misconfigurations or exposed data.

### With ZeroTrace, you can:
- 🔑 **Transform your search queries** into **optimized Google Dorks** using **AI-powered LLMs**.
- 📊 **Generate reports** with search results to document and analyze vulnerabilities.
- 📂 **Download exposed files** that may contain sensitive data (e.g., `.pdf`, `.docx`, `.txt`, etc.).
- 🌐 Identify **potential attack vectors** by scanning for data leaks and misconfigurations online.

This tool was developed as part of a **personal project** during my **cybersecurity course**, providing an opportunity to apply what I learned in a practical and educational way. **ZeroTrace** is meant to be an ethical and responsible tool for improving cybersecurity knowledge while helping you learn the ropes of ethical hacking.

## ⚠️ Disclaimer  

**ZeroTrace** was developed **exclusively for educational and research purposes** as part of my **learning experience in cybersecurity and ethical hacking**. This project serves as a **practical application of the knowledge acquired during a cybersecurity course**, allowing me to experiment in a **controlled environment** and include it in my **cybersecurity portfolio**.  

This tool is intended **solely for ethical security research** and **authorized penetration testing**. Any use **outside of legal and authorized environments**—such as reconnaissance without consent or unauthorized data access—is **strictly prohibited**.  

**Unauthorized use of ZeroTrace to gather or exploit sensitive information is illegal** and may violate laws.  

**I assume no responsibility for any misuse of this tool.** Users must ensure they have **explicit authorization** before performing any security assessments. **Always operate within legal and ethical boundaries.**  

## ⚡ **Key Features**

- **AI-Powered Dork Generation** 🤖: Uses **LLMs like Llama3** and **Groq** to generate precise Google Dorks based on user descriptions, improving the accuracy of searches.
  
- **Automated Search Queries** 🔍: Perform advanced search queries using **Google Custom Search** to retrieve relevant results and identify vulnerabilities.

- **File Downloading** 💾: Automatically download files that expose sensitive information (e.g., `.pdf`, `.docx`, `.txt`), making the reconnaissance process more efficient.

- **Detailed Reports** 📝: Export search results in **HTML** and **JSON** formats for easy documentation and further analysis.

- **Customizable Filters** 🔧: Set specific filters, such as file types or languages, to refine your search results and focus on the most relevant data.

## 🚀 **How It Works**

1. **Configure API Keys** 🔐: Set up your **Google API Key** and **Custom Search Engine ID** for seamless operation.
2. **Enter a Query**: Provide a search description or a specific Google Dork.
3. **AI-Assisted Dork Generation**: **ZeroTrace** uses **LLMs** to generate optimized Google Dorks based on your input.
4. **Retrieve Results**: Perform searches and retrieve relevant information from the web quickly and accurately.
5. **Download Files**: Automatically download exposed files containing sensitive information.
6. **Export Reports**: Save the results in **HTML** or **JSON** formats for easy documentation and analysis.

## 🧑‍💻 **Installation**

1. Clone the repository.
2. Install the required dependencies.
3. Set up your environment variables.
4. Run the tool.

## 🛠️ **API Key Configuration**

Before using ZeroTrace, you need to configure the following API keys:

- **Google Search API Key**: This key allows ZeroTrace to access Google’s powerful search capabilities. It’s required for making search requests to Google.
  
- **Custom Search Engine ID**: This ID identifies the specific Google Custom Search Engine you’ll be using. It helps tailor the search results to specific sites or content types based on your configuration.
  
- **Groq API Key**: This key is used to access Groq's AI capabilities, specifically for generating optimized Google Dorks. Groq leverages the **Llama** Large Language Model (LLM) developed by Meta, which assists in converting your search queries into effective dorks.

## 📂 **Output Formats**

ZeroTrace provides flexibility in how you view and utilize search results, offering multiple output formats:

- **Console Display** 🖥️: Search results are presented directly in the console for immediate viewing and analysis.
- **HTML Report** 📝: Nicely formatted, easy-to-read report suitable for sharing or documentation.
- **JSON Export** 🗂️: Structured data format for further processing or analysis, allowing for integration with other tools or systems.

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

## 🚀 Using ZeroTrace: A Practical Example

Below is a practical example of how to use ZeroTrace to perform an advanced search and download relevant files.
Suppose you want to search for text files containing lists of usernames and passwords. You can execute the following command in the command line:

```python
python zerotrace_cli.py -q "List of users and passwords in text file contents." --pages 2 --download-file-extensions "txt" --download-folder "downloads" --json output.json --html output.html
```

### Process Breakdown
When executing the above command, ZeroTrace follows these steps:

* Initialization:

ZeroTrace initializes with the Google API key and search engine ID, also configuring the download folder and the file types to download.

```python
2024-09-27 20:07:23,203 - INFO - 🔍 ZeroTrace initialized with Google API key and search engine ID.
2024-09-27 20:07:23,203 - INFO - 📁 Download folder set to: downloads
2024-09-27 20:07:23,203 - INFO - 📥 File extensions to download: all
```

* Dork Generation:

A Google Dork is generated based on the provided description using an AI model.

```python
2024-09-27 20:07:23,204 - INFO - 📝 Generating Google Dork for description: List of users and passwords in text file contents.
2024-09-27 20:07:27,030 - INFO - ✅ Generated Dork: filetype:txt ("username password" | "user pass" | "login credentials" | "password list")
```

* Search Execution:

The search is executed using the generated Dork, and the obtained results are processed.

```python
2024-09-27 20:07:28,587 - INFO - ✅ Search completed. Processing 13 results.
```

* Results Export:

The results are exported in HTML and JSON formats for documentation and further analysis.

```python
2024-09-27 20:07:28,663 - INFO - 📄 Exporting results to HTML: output.html
Results exported to HTML. File created: output.html
2024-09-27 20:07:28,671 - INFO - 📊 Exporting results to JSON: output.json
Results exported to JSON. File created: output.json
```

* File Download:

Files that match the search criteria are automatically downloaded and stored in the specified folder.

```python
2024-09-27 20:07:45,016 - INFO - 📥 Downloading files with types: all
File 'Readme_Baltic%20Sea%20Surface%20Salinity%20L3%20maps.txt' downloaded to 'downloads\Readme_Baltic%20Sea%20Surface%20Salinity%20L3%20maps.txt'.
...
```

* Results
Upon completion, you will receive confirmation that the results have been processed successfully, along with the downloaded files in the specified folder:

```python
2024-09-27 20:07:45,016 - INFO - ✅ Results processed successfully.
```
This example illustrates the power of ZeroTrace in automating the search and collection of sensitive information, thus optimizing the research process for cybersecurity professionals.

## 🔐 **Ethical Use**

This tool is meant for **ethical hacking** and **cybersecurity research** purposes. Ensure that you have proper authorization before using ZeroTrace for any reconnaissance activities. Unauthorized use to access or download sensitive data may be illegal in your jurisdiction.

## ⚠️ Disclaimer  

**ZeroTrace** was developed **exclusively for educational and research purposes** as part of my **learning experience in cybersecurity and ethical hacking**. This project serves as a **practical application of the knowledge acquired during a cybersecurity course**, allowing me to experiment in a **controlled environment** and include it in my **cybersecurity portfolio**.  

This tool is intended **solely for ethical security research** and **authorized penetration testing**. Any use **outside of legal and authorized environments**—such as reconnaissance without consent or unauthorized data access—is **strictly prohibited**.  

**Unauthorized use of ZeroTrace to gather or exploit sensitive information is illegal** and may violate laws.  

**I assume no responsibility for any misuse of this tool.** Users must ensure they have **explicit authorization** before performing any security assessments. **Always operate within legal and ethical boundaries.**  

## 🎯 **Future Improvements**

- 🛠️ **Additional AI Models**: Expanding support for more LLMs.
- ⚙️ **Custom Search Engines**: Adding support for more search engines beyond Google.
- 📊 **Advanced Reporting**: More detailed and customizable reports.

## 🤝 **Contributing**
Contributions to ZeroTrace are highly encouraged! If you're interested in adding new features, resolving bugs, or enhancing the project's functionality, please feel free to submit pull requests.

## Get in Touch 📬

ZeroTrace is developed and maintained by **Sergio Sánchez Sánchez** (Dream Software). Special thanks to the open-source community and the contributors who have made this project possible. If you have any questions, feedback, or suggestions, feel free to reach out at  [dreamsoftware92@gmail.com](mailto:dreamsoftware92@gmail.com).

## Visitors Count

<img width="auto" src="https://profile-counter.glitch.me/zero_trace_hacking_tool/count.svg" />

## Please Share & Star the repository to keep me motivated.
  <a href = "https://github.com/sergio11/zero_trace_hacking_tool/stargazers">
     <img src = "https://img.shields.io/github/stars/sergio11/zero_trace_hacking_tool" />
  </a>

## License ⚖️

This project is licensed under the MIT License, an open-source software license that allows developers to freely use, copy, modify, and distribute the software. 🛠️ This includes use in both personal and commercial projects, with the only requirement being that the original copyright notice is retained. 📄

Please note the following limitations:

- The software is provided "as is", without any warranties, express or implied. 🚫🛡️
- If you distribute the software, whether in original or modified form, you must include the original copyright notice and license. 📑
- The license allows for commercial use, but you cannot claim ownership over the software itself. 🏷️

The goal of this license is to maximize freedom for developers while maintaining recognition for the original creators.

```
MIT License

Copyright (c) 2024 Dream software - Sergio Sánchez 

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```
