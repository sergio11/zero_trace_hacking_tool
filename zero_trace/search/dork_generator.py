from langchain_groq import ChatGroq
from langchain_core.prompts import ChatPromptTemplate

class DorkGenerator:
    """
    Class representing an AI agent capable of generating Google Dorks based on user-provided descriptions.
    
    Attributes:
        model (ChatGroq): The Groq model used for generating Google Dorks.
        prompt_template (ChatPromptTemplate): The template for the prompt to generate Google Dorks.
    """

    def __init__(self, model_id="llama3-70b-8192", groq_api_key=None):
        """
        Initializes a new DorkGenerator with the specified Groq model and API key.
        
        Args:
            model_id (str): The ID of the Groq model to use. Default is 'llama3-70b-8192'.
            groq_api_key (str): The API key for accessing Groq services.
        """
        if not groq_api_key:
            raise ValueError("Groq API key must be provided either as an argument or an environment variable.")

        self.model = ChatGroq(model=model_id, temperature=0, api_key=groq_api_key)
        self.prompt_template = ChatPromptTemplate.from_messages(
            [
                (
                    "system",
                    """
                    Generate a specific Google Dork based on the user's description. A Google Dork uses advanced search operators to find specific information that is hard to locate through a normal search. 
                    Your task is to convert the user's description into an accurate Google Dork. Provide only the Google Dork in your response, without any additional text or prefixes. 

                    Here are some examples of how you should formulate the Google Dorks based on different descriptions:

                    Description: PDF documents related to cybersecurity published in the last year.
                    Google Dork: filetype:pdf "cybersecurity" after:2023-01-01

                    Description: PowerPoint presentations on climate change available on .edu sites.
                    Google Dork: site:.edu filetype:ppt "climate change"

                    Description: Lists of email addresses in text files within government domains.
                    Google Dork: site:.gov filetype:txt "email" | "correo electrónico"

                    Now, based on the following user-provided description, generate the corresponding Google Dork:
                    """
                ),
                ("human", "{description}"),
            ]
        )

    def generate_dork(self, description):
        """
        Generates a Google Dork based on the provided description.
        
        Args:
            description (str): Description provided by the user to generate the Google Dork.
        
        Returns:
            str: Generated Google Dork or None if an error occurs.
        """
        try:
            # Create a chain using the prompt template and the model
            chain = self.prompt_template | self.model
            # Invoke the chain with the provided description
            response = chain.invoke({"description": description})
            # Extract content from the response
            # Check the type of response and use appropriate method to access the content
            if hasattr(response, 'text'):
                content = response.text.strip()
            elif hasattr(response, 'content'):
                content = response.content.strip()
            else:
                raise TypeError("Unexpected response type: Unable to extract content.")
            return content
        except Exception as e:
            print(f"Error generating Google Dork: {e}")
            return None
