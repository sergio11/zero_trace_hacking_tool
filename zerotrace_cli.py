import os
import sys
import argparse
from zero_trace.main import SearchArgs, ZeroTrace
from dotenv import load_dotenv, set_key

def env_config():
    """
    Prompts the user to enter Google API Key, Custom Search Engine ID,
    and Groq API Key, then stores these values in a .env file for future use.
    """
    api_key = input("Enter your Google API KEY: ")
    engine_id = input("Enter your Google Custom Search Engine ID: ")
    groq_api_key = input("Enter your GROQ API KEY: ")
    
    set_key(".env", "API_KEY_GOOGLE", api_key)
    set_key(".env", "SEARCH_ENGINE_ID", engine_id)
    set_key(".env", "GROQ_API_KEY", groq_api_key)
    
    print("Configuration saved to .env file successfully.")

def main():
    """
    Main entry point for the ZeroTrace CLI tool. Handles command-line arguments,
    runs searches, and processes results.
    """
    # Argument parser setup
    parser = argparse.ArgumentParser(description="ZeroTrace: A tool for automated advanced Google searches.")

    # Dork query argument
    parser.add_argument("-d", "--dork", type=str, default=None, help="Specify the Google Dork or search query. Example: -d 'filetype:sql \"MySQL dump\" (pass|password|passwd|pwd)'")

    # AI-generated Dork argument
    parser.add_argument("-q", "--query-dork", type=str, default=None, help="Automatically generates a Google Dork based on a description using AI.")

    # Configuration flag
    parser.add_argument("-c", "--configure", action="store_true", help="Configure or update the .env file with API credentials.")
    
    # Search start page and number of pages arguments
    parser.add_argument("--start-page", type=int, default=1, help="The starting page number for search results (default: 1).")
    parser.add_argument("--pages", type=int, default=1, help="The number of pages to retrieve (default: 1).")
    
    # Language code argument
    parser.add_argument("--lang", type=str, default="lang_es", help="Language code for search results. Default is 'lang_es' (Spanish).")
    
    # Output options for JSON and HTML
    parser.add_argument("--json", type=str, help="Export results to the specified file in JSON format.")
    parser.add_argument("--html", type=str, help="Export results to the specified file in HTML format.")
    
    parser.add_argument(
        "--download-file-extensions", 
        type=str, 
        default="all", 
        help="Specify file extensions to download, separated by commas. Example: --download-file-extensions 'pdf,doc,sql'. "
            "Use 'all' to download files of all types."
    )

    parser.add_argument(
        "--download-folder", 
        type=str, 
        default="downloads", 
        help="Specify the folder where downloaded files will be saved. "
            "Example: --download-folder 'downloaded_files'. "
            "Use 'all' to save files in the current directory."
    )

    # Parse arguments from the command line
    args = parser.parse_args()

    # Handle environment configuration
    if args.configure:
        env_config()
        sys.exit(0)

    # Load environment variables from the .env file
    load_dotenv()

    # Retrieve API key and search engine ID from the environment variables
    google_api_key = os.getenv("API_KEY_GOOGLE")
    search_engine_id = os.getenv("SEARCH_ENGINE_ID")
    groq_api_key = os.getenv("GROQ_API_KEY")

    # Check if API credentials are available
    if not google_api_key or not search_engine_id:
        print("ERROR: Missing API_KEY or SEARCH_ENGINE_ID. Run with --configure to set them up.")
        sys.exit(1)

    if not args.query_dork and not args.dork:
        print("ERROR: A query dork or dork must be provided. Use the -q or -d option to specify the query.")
        sys.exit(1)

    # Initialize ZeroTrace with the API key and search engine ID
    zerotrace = ZeroTrace(
        google_api_key=google_api_key, 
        search_engine_id=search_engine_id, 
        groq_api_key=groq_api_key,
        output_html=args.html, 
        output_json=args.json, 
        download_file_extensions=args.download_file_extensions,
        download_folder=args.download_folder
    )

    searchArgs = SearchArgs(
        start_page=args.start_page, 
        pages=args.pages, 
        lang=args.lang
    )

    # Perform the search
    if args.dork:
        zerotrace.search_with_dork(query=args.dork, search_args = searchArgs)
    else:
        zerotrace.generate_dork_and_search(description=args.query_dork, search_args = searchArgs)

if __name__ == "__main__":
    main()