import os
import sys
import argparse
from zerotrace import ZeroTrace
from dotenv import load_dotenv, set_key

def env_config():
    """
    Prompts the user to enter Google API Key and Custom Search Engine ID,
    then stores these values in a .env file for future use.
    """
    api_key = input("Enter your Google API KEY: ")
    engine_id = input("Enter your Google Custom Search Engine ID: ")
    set_key(".env", "API_KEY_GOOGLE", api_key)
    set_key(".env", "SEARCH_ENGINE_ID", engine_id)
    print("Configuration saved to .env file successfully.")

def main():
    """
    Main entry point for the ZeroTrace CLI tool. Handles command-line arguments,
    runs searches, and processes results.
    """
    # Argument parser setup
    parser = argparse.ArgumentParser(description="ZeroTrace: A tool for automated advanced Google searches.")

    # Search query argument
    parser.add_argument("-q", "--query", type=str, help="Specify the Google Dork or search query. Example: -q \"filetype:sql 'MySQL dump' (pass|password|passwd|pwd)\"")
    
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

    # Parse arguments from the command line
    args = parser.parse_args()

    # Handle environment configuration
    if args.configure:
        env_config()
        sys.exit(0)

    # Ensure that query is provided
    if not args.query:
        print("ERROR: A search query is required. Use the -q option to specify the query.")
        sys.exit(1)

    # Load environment variables from the .env file
    load_dotenv()

    # Retrieve API key and search engine ID from the environment variables
    google_api_key = os.getenv("API_KEY_GOOGLE")
    search_engine_id = os.getenv("SEARCH_ENGINE_ID")

    # Check if API credentials are available
    if not google_api_key or not search_engine_id:
        print("ERROR: Missing API_KEY or SEARCH_ENGINE_ID. Run with --configure to set them up.")
        sys.exit(1)

    # Initialize ZeroTrace with the API key and search engine ID
    zerotrace = ZeroTrace(google_api_key, search_engine_id)

    # Perform the search
    results = zerotrace.run_search(query=args.query, start_page=args.start_page, pages=args.pages, lang=args.lang)

    # Process and export results (if needed)
    zerotrace.process_results(results, output_html=args.html, output_json=args.json)

if __name__ == "__main__":
    main()