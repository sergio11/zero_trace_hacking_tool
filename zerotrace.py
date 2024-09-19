from dotenv import load_dotenv
import os
from googlesearch import GoogleSearch

def load_api_credentials():
    """
    Loads API credentials from environment variables using dotenv.
    
    Returns:
        tuple: A tuple containing the Google API key and the Custom Search Engine ID.
    
    Raises:
        EnvironmentError: If either the API key or search engine ID is missing.
    """
    load_dotenv()  # Load environment variables from .env file

    api_key = os.getenv("API_KEY_GOOGLE")
    search_engine_id = os.getenv("SEARCH_ENGINE_ID")

    if not api_key or not search_engine_id:
        raise EnvironmentError("API key or Search Engine ID is missing. Please check your .env file.")

    return api_key, search_engine_id


def perform_google_search(api_key, search_engine_id, query, pages=1):
    """
    Performs a Google search using the provided query and returns the results.
    
    Args:
        api_key (str): Google API key.
        search_engine_id (str): Google Custom Search Engine ID.
        query (str): The search query string.
        pages (int, optional): Number of pages of results to retrieve (default is 1).
    
    Returns:
        list: A list of search results.
    
    Raises:
        Exception: If the search query fails.
    """
    # Create a GoogleSearch instance
    gsearch = GoogleSearch(api_key, search_engine_id)

    # Perform the search and return the results
    return gsearch.search(query, pages=pages)


def main():
    """
    Main function to execute the Google search and print the results.
    """
    try:
        # Load API credentials
        api_key, search_engine_id = load_api_credentials()

        # Define the search query
        query = 'filetype:sql "MySQL dump" (pass|password|passwd|pwd)'

        # Log the query safely (avoid logging sensitive queries in production)
        print(f"Performing search with query: {query}")

        # Perform the search and get results (retrieving 2 pages)
        results = perform_google_search(api_key, search_engine_id, query, pages=2)

        # Print the search results
        for idx, result in enumerate(results, start=1):
            print(f"Result {idx}:")
            print(f"Title: {result['title']}")
            print(f"Description: {result['description']}")
            print(f"Link: {result['link']}\n")

    except Exception as e:
        print(f"An error occurred: {e}")


if __name__ == "__main__":
    main()
