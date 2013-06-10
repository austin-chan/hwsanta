//
//  SelectPrepViewController.h
//  HopingForAWish
//
//  Created by Austin Chan on 12/3/12.
//  Copyright (c) 2012 Austin Chan. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface SelectPrepViewController : UIViewController
@property (weak, nonatomic) IBOutlet UILabel *header;
@property (weak, nonatomic) IBOutlet UILabel *loadingChoices;
@property (weak, nonatomic) IBOutlet UIActivityIndicatorView *loadingIndicator;
- (IBAction)startSelected:(id)sender;

@end
