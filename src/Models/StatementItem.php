<?php
/*******************************************************************************************
Copyright © 2019 Xiippy.ai. All rights reserved. Australian patents awarded. PCT patent pending.

NOTES:

- No payment gateway SDK function is consumed directly. Interfaces are defined out of such interactions and then the interface is implemented for payment gateways. Design the interface with the most common members and data structures between different gateways. 
A proper factory or provider must instantiate an instance of the interface that is interacted with.
- Any major change made to SDKs should begin with the c# SDK with the mindset to keep the high-level syntax, structures and class names the same to minimise porting efforts to other languages. Do not use language specific features that don't exist in other languages. We are not in the business of doing the same thing from scratch multiple times in different forms.
- Pascal Case for naming conventions should be used for all languages
- No secret or passwords or keys must exist in the code when checked in

*******************************************************************************************/

 

namespace Xiippy\POSeComSDK\Light\Models
{


    class StatementItem

    {


        public int $StatementItemID ;


        //[Indexed] // foreign key from IssuerStatementRecordPersisted
        public string $RandomStatementID ;

        public string $Description = "";



        public string $Identifier = "";



        public string $Url = "";


        public Float $Quantity ;


        public Float $UnitPrice ;


        public Float $TotalPrice ;


        public Float $Tax ;



        public string $ExtraInfo1 = "";



        public string $ExtraInfo2 = "";



        public string $ExtraInfo3 = "";



        public string $ExtraInfo4 = "";



        public string $ExtraInfo6 = "";



        public string $ExtraInfo5 = "";



        public string $UnitTitle = "";


        public Float $UnitLoyaltyPoint ;


        public Float $LoyaltyPoint ;



        public string $ItemClsassification = "";



        public string $ItemCategoryID = "";



        public string $ItemCategoryTitle = "";









        /// <summary>
        /// Defines what moment this item has been added to the bill. Combined with a charge's OnlyAppliesOnceWithinMinutes, the engine can determine if a row can be added to a bill or not!
        /// </summary>
        public DateTime  $AddedMoment ;

    }
}
?>