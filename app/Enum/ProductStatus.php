<?php

namespace App\Enum;

enum ProductStatus: string
{
    case DRAFT = 'draft';
    // The product information is being created and is not yet ready for use in the ERP system.

    case PENDING_APPROVAL = 'pending_approval';
    // The product is awaiting approval from management or other relevant departments.

    case ACTIVE = 'active';
    // The product is live and available for transactions, including sales and purchasing.

    case INACTIVE = 'inactive';
    // The product is not currently available for transactions but can be reactivated in the future.

    case DISCONTINUED = 'discontinued';
    // The product is no longer available and will not be restocked.

    case OUT_OF_STOCK = 'out_of_stock';
    // The product is temporarily unavailable due to lack of inventory.

    case BACKORDERED = 'backordered';
    // The product is out of stock but can be ordered now for future delivery.

    case PREORDER = 'preorder';
    // The product can be ordered before it is officially available.

    case ARCHIVED = 'archived';
    // The product is no longer available and has been moved to an archive state.

    case RESERVED = 'reserved';
    // The product is reserved for specific orders or customers and is not available for general sale.

    case UNDER_REVIEW = 'under_review';
    // The product is undergoing quality, compliance, or other reviews.

    case OBSOLETE = 'obsolete';
    //  The product is outdated and replaced by a newer version.

    case IN_PRODUCTION = 'in_production';
    //  The product is currently being manufactured or assembled.

    case AWAITING_SHIPMENT = 'awaiting_shipment';
    // The product is ready and waiting to be shipped to customers or distributors.

    case RECALLED = 'recalled';
    // The product has been recalled due to quality issues or regulatory non-compliance.
}
