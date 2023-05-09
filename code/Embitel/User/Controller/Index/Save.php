<?php
namespace Embitel\User\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\View\Element\Messages;
use Embitel\User\Model\TestFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Zend\Mime\Part;
use Zend\Mime\Mime;
use Zend\Mime\PartFactory;

class Save extends \Magento\Framework\App\Action\Action
{
    /**
     * @var TestFactory
     */
    protected $testFactory;
    protected $transportBuilder;
    protected $inlineTranslation;
    protected $storeManager;
    protected $fileUploaderFactory;
    protected $filesystem;

    public function __construct(
        Context $context,
        TestFactory $testFactory,
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        StoreManagerInterface $storeManager,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
        Filesystem $filesystem
    ) {
        $this->testFactory = $testFactory;
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->storeManager = $storeManager;
        $this->fileUploaderFactory = $fileUploaderFactory;
        $this->filesystem = $filesystem;
        parent::__construct($context);
    }

    public function execute()
    {
        $request_data = $this->getRequest()->getParams();
        $uploadedFile = $this->getRequest()->getFiles('attachment-pdf');
        //print_r($uploadedFile["name"]);die;

        $data = [
            'name' => $request_data['name'],
            'email' => $request_data['email'],
            'phone' => $request_data['phone'],
            'location' => $request_data['location'],
            'attachment-pdf' => $uploadedFile["name"],
            'date_of_birth' => $request_data['date_of_birth'],
        ];

        $testFactory = $this->testFactory->create();
        $test = $testFactory->setData($data);
        $test->save();

        if ($test->getUser_id()) {
            $this->messageManager->addSuccessMessage(__('Your Application has been sent.'));

            // Send email to the customer
            $templateVars = [
                'data' => $data,
                'subject' => 'Job Application', // Set the subject
                'attachment_url' => '',
                'attachment_name' => '',
            ];
            
            // $from = ['email' => 'shashankganesh53@gmail.com', 'name' => 'Shashank'];
            // $to = [$data['email'], $data['name']];
            $from = ['email' => $data['email'], 'name' => $data['name']];
            $to = ['shashankganesh53@gmail.com', 'Shashank'];
            

            $storeId = $this->storeManager->getStore()->getId();

            try {
                $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
                $templateOptions = [
                    'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => $storeId,
                ];

                $this->inlineTranslation->suspend();
                $transport = $this->transportBuilder
                    ->setTemplateIdentifier('user_confirmation')
                    ->setTemplateOptions($templateOptions)
                    ->setTemplateVars($templateVars)
                    ->setFrom($from)
                    ->addTo($to)
                    ->getTransport();

                // Get the uploaded file information
                if ($uploadedFile && !empty($uploadedFile['name'])) {
                    try {
                        $uploader = $this->fileUploaderFactory->create(['fileId' => 'attachment-pdf']);
                        $uploader->setAllowedExtensions(['pdf']);
                        //$uploader->setAllowRename(true);
                        $uploader->setFilesDispersion(true);
                        $destinationPath = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath('tmp');
                        $result = $uploader->save($destinationPath);

                        if ($result['file']) {
                            $attachmentFile = $result['file'];
                            $attachmentFilePath = $destinationPath . $attachmentFile;

                            // Attach the file to the email
                            $attachmentPart = new Part(file_get_contents($attachmentFilePath));
                            $attachmentPart->setType(Mime::TYPE_OCTETSTREAM);
                            $attachmentPart->setDisposition(Mime::DISPOSITION_ATTACHMENT);
                            $attachmentPart->setEncoding(Mime::ENCODING_BASE64);
                            $attachmentPart->setFileName($uploadedFile['name']);
                           

                            $body = $transport->getMessage()->getBody();
                            $body->addPart($attachmentPart);
                            $transport->getMessage()->setBody($body);

                            // Update the template variables
                            $templateVars['attachment_url'] = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'tmp/' . $attachmentFile;
                            $templateVars['attachment_name'] = $uploadedFile['name'];
                        } else {
                            throw new LocalizedException(__('File upload failed.'));
                        }
                    } catch (\Exception $e) {
                        throw new LocalizedException(__('File upload failed: %1', $e->getMessage()));
                    }
                }

                $transport->sendMessage();
                $this->inlineTranslation->resume();
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Error sending email.'));
            }
        } else {
            $this->messageManager->addErrorMessage(__('Data was not saved.'));
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('user/index/index');
        return $resultRedirect;
    }
}
